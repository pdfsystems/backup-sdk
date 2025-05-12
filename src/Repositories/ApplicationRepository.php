<?php

namespace Pdfsystems\BackupSdk\Repositories;

use GuzzleHttp\Exception\GuzzleException;
use Pdfsystems\BackupSdk\Dtos\Application;
use Pdfsystems\BackupSdk\Dtos\Pagination\ApplicationList;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

class ApplicationRepository extends Repository
{
    /**
     * @throws UnknownProperties
     * @throws GuzzleException
     */
    public function list(int $perPage = 15, int $page = 1): ApplicationList
    {
        return $this->client->getDto('api/applications', ApplicationList::class, [
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

    /**
     * @throws UnknownProperties
     * @throws GuzzleException
     */
    public function create(Application $application): Application
    {
        return $this->client->postDto('api/applications', $application);
    }

    /**
     * @throws UnknownProperties
     * @throws GuzzleException
     */
    public function update(Application $application): Application
    {
        return $this->client->putDto("api/applications/$application->id", $application);
    }
}
