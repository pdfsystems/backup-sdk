<?php

namespace Pdfsystems\BackupSdk\Dtos\Pagination;

use Spatie\DataTransferObject\Attributes\CastWith;
use Spatie\DataTransferObject\Casters\ArrayCaster;
use Spatie\DataTransferObject\DataTransferObject;

abstract class PaginatedResult extends DataTransferObject
{
    public int $current_page;
    public array $data;
    public string $first_page_url;
    public ?int $from;
    public int $last_page;
    public string $last_page_url;
    /** @var Link[] */
    #[CastWith(ArrayCaster::class, itemType: Link::class)]
    public array $links;
    public ?string $next_page_url;
    public string $path;
    public int $per_page;
    public ?string $prev_page_url;
    public ?int $to;
    public int $total;
}
