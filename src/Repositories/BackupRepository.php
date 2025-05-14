<?php

namespace Pdfsystems\BackupSdk\Repositories;

use GuzzleHttp\Exception\GuzzleException;
use Pdfsystems\BackupSdk\Dtos\Application;
use Pdfsystems\BackupSdk\Dtos\Backup;
use Pdfsystems\BackupSdk\Dtos\Pagination\BackupList;
use Rpungello\SdkClient\SdkClient;
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
