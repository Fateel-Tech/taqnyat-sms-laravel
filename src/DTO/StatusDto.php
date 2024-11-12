<?php

namespace FateelTech\TaqnyatSmsLaravel\DTO;

class StatusDto
{
    public function __construct(
        public string $service,
        public string $description,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            service: $data['service'],
            description: $data['description'],
        );
    }

    public function getService(): string
    {
        return $this->service;
    }

    public function getDescription(): string
    {
        return $this->description;
    }
}
