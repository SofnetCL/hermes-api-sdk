<?php

namespace HermesSdk\Domains;

use HermesSdk\Email;
use HermesSdk\HttpApiClient;
use HermesSdk\Service;
use HermesSdk\Status;

class Admin
{
    private const SERVICE = 'admin';

    public function __construct(
        private HttpApiClient $httpApiClient
    ) {}

    /**
     * @return Email
     */
    public function sendWelcomeUserMail(string $email, string $userName, string $tempPassword): Email
    {
        $email = $this->httpApiClient->post('emails', [
            'service' => self::SERVICE,
            'key' => 'user_welcome',
            'destination' => $email,
            'params' => [
                'user_name' => $userName,
                'user_temp_password' => $tempPassword,
            ],
        ]);

        return new Email(
            $email['id'],
            Service::from($email['service']),
            $email['key'],
            $email['destination'],
            $email['params'],
            Status::from($email['status']),
            $email['created_at'],
            $email['sent_at'] ?? '',
            $email['error'] ?? '',
            $email['error_trace'] ?? '',
        );
    }
}