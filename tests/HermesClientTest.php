<?php

namespace HermesSdk\Tests;

use HermesSdk\HermesClient;
use HermesSdk\HttpApiClient;
use HermesSdk\Email;
use PHPUnit\Framework\TestCase;

class HermesClientTest extends TestCase
{
    private HermesClient $hubClient;
    private $httpApiClientMock;

    protected function setUp(): void
    {
        // Crear un mock de HttpApiClient
        $this->httpApiClientMock = $this->createMock(HttpApiClient::class);

        // Inyectar el mock en HubClient usando reflexión
        $this->hubClient = new HermesClient('fake_api_key', 'https://api.example.com');
        $reflection = new \ReflectionClass($this->hubClient);
        $httpApiClientProperty = $reflection->getProperty('httpApiClient');
        $httpApiClientProperty->setAccessible(true);
        $httpApiClientProperty->setValue($this->hubClient, $this->httpApiClientMock);
    }

    public function testSendWelcomeUserMail()
    {
        $mockResponse = [
            'service' => 'admin',
            'key' => 'user_welcome',
            'destination' => 'email@domain.com',
            'params' => [
                'user_name' => 'User Name',
                'user_temp_password' => 'tmp',
                'change_password_at_next_login' => false,
            ],
            'id' => '9d6d7208-2a7a-4b07-8609-2bcdcdfdd8f5',
            'updated_at' => '2024-11-06T22:58:21.000000Z',
            'created_at' => '2024-11-06T22:58:21.000000Z',
            'status' => 'sent',
            'sent_at' => '2024-11-06T22:58:21.436339Z',
        ];

        $this->httpApiClientMock->method('post')
            ->willReturn($mockResponse);

        $destination = 'email@domain.com';
        $userName = 'User Name';
        $tempPassword = 'tmp';
        $email = $this->hubClient->admin()->sendWelcomeUserMail($destination, $userName, $tempPassword);

        $this->assertInstanceOf(Email::class, $email);
        $this->assertEquals($mockResponse['id'], $email->getId());
        $this->assertEquals($mockResponse['service'], $email->getService()->value);
        $this->assertEquals($mockResponse['key'], $email->getKey());
        $this->assertEquals($mockResponse['destination'], $email->getDestination());
        $this->assertEquals($mockResponse['params'], $email->getParams());
    }
}
