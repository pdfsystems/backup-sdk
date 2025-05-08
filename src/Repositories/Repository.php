<?php

namespace Pdfsystems\BackupSdk\Repositories;

use Pdfsystems\BackupSdk\BackupClient;

abstract class Repository
{
    public function __construct(protected BackupClient $client) {}
}
