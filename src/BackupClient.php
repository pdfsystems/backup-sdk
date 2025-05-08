<?php

namespace Pdfsystems\BackupSdk;

use Composer\InstalledVersions;
use GuzzleHttp\HandlerStack;
use OutOfBoundsException;
use Pdfsystems\BackupSdk\Repositories\ApplicationRepository;
use Pdfsystems\BackupSdk\Repositories\BackupRepository;
use Rpungello\SdkClient\SdkClient;

class BackupClient extends SdkClient
{
    public function __construct(private string $authToken, string $baseUri = 'https://backup.pdfsystems.com', ?HandlerStack $handler = null)
    {
        parent::__construct($baseUri, $handler, static::getUserAgent());
    }

    private static function getUserAgent(): string
    {
        return 'PDF Backup SDK/' . static::getVersion();
    }

    private static function getVersion(): string
    {
        try {
            return InstalledVersions::getVersion('pdfsystems/backup-sdk');
        } catch (OutOfBoundsException) {
            return 'dev';
        }
    }

    protected function getGuzzleClientConfig(): array
    {
        $config = parent::getGuzzleClientConfig();
        $config['headers']['authorization'] = "Bearer $this->authToken";

        return $config;
    }

    public function applications(): ApplicationRepository
    {
        return new ApplicationRepository($this);
    }

    public function backups(): BackupRepository
    {
        return new BackupRepository($this);
    }
}
