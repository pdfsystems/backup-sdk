<?php

namespace Pdfsystems\BackupSdk\Dtos\Pagination;

use Pdfsystems\BackupSdk\Dtos\Application;
use Spatie\DataTransferObject\Attributes\CastWith;
use Spatie\DataTransferObject\Casters\ArrayCaster;

class ApplicationList extends PaginatedResult
{
    /** @var Application[] */
    #[CastWith(ArrayCaster::class, itemType: Application::class)]
    public array $data;
}
