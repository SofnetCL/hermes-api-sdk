<?php

namespace HermesSdk;

class Email
{
    /**  @var array<Email> */
    private array $retries = [];

    public function __construct(
        private string $id,
        private Service $service,
        private string $key,
        private string $destination,
        private array $params = [],
        private Status $status,
        private string $createdAt,
        private string $sentAt = '',
        private string $error = '',
        private string $errorTrace = '',
    ) {}

    public function getId(): string
    {
        return $this->id;
    }

    public function getService(): Service
    {
        return $this->service;
    }

    public function getKey(): string
    {
        return $this->key;
    }

    public function getDestination(): string
    {
        return $this->destination;
    }

    public function getParams(): array
    {
        return $this->params;
    }

    public function getStatus(): Status
    {
        return $this->status;
    }

    public function getCreatedAt(): string
    {
        return $this->createdAt;
    }

    public function getSentAt(): string
    {
        return $this->sentAt;
    }

    public function getError(): string
    {
        return $this->error;
    }

    public function getErrorTrace(): string
    {
        return $this->errorTrace;
    }

    public function addRetry(Email $email): void
    {
        $this->retries[] = $email;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'service' => $this->service->value,
            'key' => $this->key,
            'destination' => $this->destination,
            'params' => $this->params,
            'status' => $this->status->value,
            'created_at' => $this->createdAt,
            'error' => $this->error,
            'error_trace' => $this->errorTrace,
            'retries' => array_map(fn($email) => $email->toArray(), $this->retries),
        ];
    }
}
