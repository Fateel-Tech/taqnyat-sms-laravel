<?php

namespace FateelTech\TaqnyatSmsLaravel\DTO;

class MessageDataDto
{
    public function __construct(
        public int $statusCode,
        public int $messageId,
        public string $cost,
        public string $currency,
        public int $totalCount,
        public int $msgLength,
        public string $accepted, // [966550000000,]
        public string $rejected,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            statusCode: $data['statusCode'],
            messageId: $data['messageId'],
            cost: $data['cost'],
            currency: $data['currency'],
            totalCount: $data['totalCount'],
            msgLength: $data['msgLength'],
            accepted: $data['accepted'],
            rejected: $data['rejected'],
        );
    }

    public static function fake(): array
    {
        return [
            'statusCode' => 200,
            'messageId' => 1,
            'cost' => '0.1',
            'currency' => 'SAR',
            'totalCount' => 1,
            'msgLength' => 10,
            'accepted' => '[966550000000,]',
            'rejected' => '',
        ];
    }

    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    public function getMessageId(): int
    {
        return $this->messageId;
    }

    public function getCost(): string
    {
        return $this->cost;
    }

    public function getCurrency(): string
    {
        return $this->currency;
    }

    public function getTotalCount(): int
    {
        return $this->totalCount;
    }

    public function getMsgLength(): int
    {
        return $this->msgLength;
    }

    /**
     * Get the accepted phone numbers as an array of PhoneNumberDTO.
     *
     * @return PhoneNumberDTO[] Array of PhoneNumberDTO objects
     */
    public function getAccepted(): array
    {
        $acceptedList = trim($this->accepted, '[]');
        $phoneNumbers = array_filter(explode(',', $acceptedList), fn ($phone) => ! empty($phone));

        return array_map(fn ($phone) => new PhoneNumberDto($phone), $phoneNumbers);
    }
}
