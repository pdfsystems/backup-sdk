<?php

namespace Pdfsystems\BackupSdk\Dtos;

use Carbon\Carbon;
use Rpungello\SdkClient\DataTransferObject;

class Application extends DataTransferObject
{
    public ?int $id;
    public ?string $name;
    public ?Carbon $created_at;
    public ?Carbon $updated_at;
}
