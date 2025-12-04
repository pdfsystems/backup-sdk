<?php

namespace Pdfsystems\BackupSdk\Drivers;

use Composer\InstalledVersions;
use OutOfBoundsException;

trait BackupDriver
{
    protected static function getUserAgent(): string
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
}
