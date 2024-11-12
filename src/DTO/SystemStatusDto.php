<?php

namespace FateelTech\TaqnyatSmsLaravel\DTO;

class SystemStatusDto
{
    public function __construct(
        public int $statusCode,
        public StatusDto $status,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            statusCode: $data['statusCode'],
            status: StatusDto::fromArray($data['status']),
        );
    }

    public function getStatus(): StatusDto
    {
        return $this->status;
    }

    public function isUp(): bool
    {
        return $this->statusCode === 200;
    }
}
