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
    public function list(int $perPage = 15, int $page = 1): BackupList
    {
        return $this->client->getDto('api/backups', BackupList::class, [
            'count' => $perPage,
            'page' => $page,
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
    public function create(Application $application, SplFileInfo $file, array $meta = [], ?string $disk = null): Backup
    {
        $body = SdkClient::convertJsonToMultipart([
            'application_id' => $application->id,
            'filename' => $file->getFilename(),
            'size' => $file->getSize(),
            'mime_type' => $file->getType(),
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
