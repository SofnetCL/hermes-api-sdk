<?php

namespace HermesSdk;

use HermesSdk\Domains\Admin;

class HermesClient
{
    private HttpApiClient $httpApiClient;

    public function __construct(string $apiKey, string $apiUrl)
    {
        $this->httpApiClient = new HttpApiClient();
        $this->httpApiClient->setHeaders([
            'Authorization' => "ApiKey $apiKey",
        ]);
        $this->httpApiClient->setBaseUrl($apiUrl);
    }

    public function admin(): Admin
    {
        return new Admin($this->httpApiClient);
    }
}
