<?php

namespace Pdfsystems\BackupSdk;

use Pdfsystems\BackupSdk\Repositories\ApplicationRepository;
use Pdfsystems\BackupSdk\Repositories\BackupRepository;
use Rpungello\SdkClient\SdkClient;

class BackupClient extends SdkClient
{
    public function applications(): ApplicationRepository
    {
        return new ApplicationRepository($this);
    }

    public function backups(): BackupRepository
    {
        return new BackupRepository($this);
    }
}
