<?php

namespace Pdfsystems\BackupSdk\Repositories;

use GuzzleHttp\Exception\GuzzleException;
use Pdfsystems\BackupSdk\Dtos\Application;
use Pdfsystems\BackupSdk\Dtos\Pagination\BackupList;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

class ApplicationRepository extends Repository
{
    /**
     * @throws UnknownProperties
     * @throws GuzzleException
     */
    public function list(int $perPage = 15, int $page = 1): BackupList
    {
        return $this->client->getDto('api/applications', BackupList::class, [
            'count' => $perPage,
            'page' => $page,
        ]);
    }

    /**
     * @throws UnknownProperties
     * @throws GuzzleException
     */
    public function find(int $id): Application
    {
        return $this->client->getDto("api/applications/$id", Application::class);
    }
}
