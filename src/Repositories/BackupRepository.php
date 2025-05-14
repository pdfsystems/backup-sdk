<?php

namespace Pdfsystems\BackupSdk\Repositories;

use GuzzleHttp\Exception\GuzzleException;
use Pdfsystems\BackupSdk\Dtos\Application;
use Pdfsystems\BackupSdk\Dtos\Backup;
use Pdfsystems\BackupSdk\Dtos\Pagination\BackupList;
use Rpungello\SdkClient\SdkClient;
use RuntimeException;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;
use SplFileInfo;

class BackupRepository extends Repository
{
    /**
     * @throws UnknownProperties
     * @throws GuzzleException
     */
    public function list(Application|int|null $application = null, ?string $type = null, int $perPage = 15, int $page = 1): BackupList
    {
        return $this->client->getDto('api/backups', BackupList::class, [
            'count' => $perPage,
            'page' => $page,
            'application_id' => is_int($application) ? $application : $application?->id,
            'type' => $type,
        ]);
    }

    /**
     * @throws UnknownProperties
     * @throws GuzzleException
     */
    public function find(int $id): Backup
    {
        return $this->client->getDto("api/backups/$id", Backup::class);
    }

    /**
     * @throws GuzzleException
     */
    public function download(Backup|int $backup, string $localDirectory, ?string $filename = null): void
    {
        $id = is_int($backup) ? $backup : $backup->id;
        $response = $this->client->get("api/backups/$id/download");

        if (empty($filename)) {
            $disposition = $response->getHeader('Content-Disposition')[0];
            if (preg_match('/filename="?([^"]+)"?/', $disposition, $matches)) {
                $filename = $matches[1];
            } else {
                throw new RuntimeException('Unable to determine filename');
            }
        }
        $fh = fopen("$localDirectory/$filename", 'wb');
        if ($fh === false) {
            throw new RuntimeException("Unable to open file for writing: $localDirectory/$filename");
        }

        $result = fwrite($fh, $response->getBody());
        if ($result === false) {
            fclose($fh);
            throw new RuntimeException("Unable to write to file: $localDirectory/$filename");
        }

        fclose($fh);
    }

    /**
     * @throws GuzzleException
     */
    public function create(Application|int $application, SplFileInfo $file, array $meta = [], ?string $type = null, ?string $disk = null): Backup
    {
        $body = SdkClient::convertJsonToMultipart([
            'application_id' => is_int($application) ? $application : $application->id,
            'filename' => $file->getFilename(),
            'size' => $file->getSize(),
            'type' => $type,
            'mime_type' => mime_content_type($file->getPathname()),
            'meta' => json_encode($meta),
            'disk' => $disk,
        ]);

        $body[] = [
            'name' => 'file',
            'contents' => $file->openFile(),
            'filename' => $file->getFilename(),
        ];

        return $this->client->postMultipartAsDto('api/backups', $body, Backup::class);
    }

    /**
     * @throws UnknownProperties
     * @throws GuzzleException
     */
    public function update(Backup $backup): Backup
    {
        return $this->client->putDto("api/backups/$backup->id", $backup);
    }
}
