<?php

namespace Pdfsystems\BackupSdk\Drivers;

use GuzzleHttp\HandlerStack;

class GuzzleDriver extends \Rpungello\SdkClient\Drivers\GuzzleDriver
{
    use BackupDriver;

    public function __construct(private readonly string $authToken, string $baseUri, HandlerStack $handler = null)
    {
        parent::__construct($baseUri, $handler, static::getUserAgent());
    }

    protected function getGuzzleClientConfig(): array
    {
        $config = parent::getGuzzleClientConfig();
        $config['headers']['authorization'] = "Bearer $this->authToken";

        return $config;
    }
}
