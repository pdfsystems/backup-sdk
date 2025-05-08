<?php

namespace Pdfsystems\BackupSdk\Repositories;

use GuzzleHttp\Exception\GuzzleException;
use Pdfsystems\BackupSdk\Dtos\Backup;
use Pdfsystems\BackupSdk\Dtos\Pagination\BackupList;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

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
}
