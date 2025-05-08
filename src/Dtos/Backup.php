<?php

namespace Pdfsystems\BackupSdk\Dtos;

use Carbon\Carbon;
use Rpungello\SdkClient\DataTransferObject;

class Backup extends DataTransferObject
{
    public ?int $id;
    public ?Application $application;
    public ?string $disk;
    public ?string $filename;
    public ?string $mime_type;
    public ?int $size;
    public array $meta = [];
    public ?Carbon $created_at;
    public ?Carbon $updated_at;

}
