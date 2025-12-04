<?php

namespace Pdfsystems\BackupSdk\Drivers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\Client\PendingRequest;

class LaravelDriver extends \Rpungello\SdkClient\Drivers\LaravelDriver
{
    use BackupDriver;

    public function __construct(Application $app, string $baseUri, private readonly string $authToken)
    {
        parent::__construct($app, $baseUri);
    }

    protected function pendingRequest(array $headers = []): PendingRequest
    {
        return parent::pendingRequest($headers)
            ->withUserAgent(static::getUserAgent())
            ->withToken($this->authToken);
    }
}
