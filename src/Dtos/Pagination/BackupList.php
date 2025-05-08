<?php

namespace Pdfsystems\BackupSdk\Dtos\Pagination;

use Pdfsystems\BackupSdk\Dtos\Backup;
use Spatie\DataTransferObject\Attributes\CastWith;
use Spatie\DataTransferObject\Casters\ArrayCaster;

class BackupList extends PaginatedResult
{
    /** @var Backup[] */
    #[CastWith(ArrayCaster::class, itemType: Backup::class)]
    public array $data;
}
