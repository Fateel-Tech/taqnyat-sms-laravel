<?php

namespace FateelTech\TaqnyatSmsLaravel;

use FateelTech\TaqnyatSmsLaravel\DTO\AccountBalanceDto;
use FateelTech\TaqnyatSmsLaravel\DTO\MessageDataDto;
use FateelTech\TaqnyatSmsLaravel\DTO\SystemStatusDto;
use FateelTech\TaqnyatSmsLaravel\Exceptions\TaqnyatRequestException;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;

class TaqnyatSmsLaravel
{
    private PendingRequest $httpClient;

    public function __construct(private string $endpoint, private string $token, private string $senderName, private int $timeout)
    {
        $this->httpClient = Http::withUrlParameters([
            'endpoint' => $this->endpoint,
        ])->withToken(
            token: $this->token,
        )->withHeaders([
            'Accept' => 'application/json',
        ])->timeout(
            seconds: $this->timeout,
        );
    }

    /**
     * This method retrieves the service status.
     *
     * @return SystemStatusDto The response data from the API.
     *
     * @throws TaqnyatRequestException|ConnectionException
     */
    public function getServiceStatus(): SystemStatusDto
    {
        $response = $this->httpClient->get(
            url: $this->url('system/status'),
        );

        if ($response->status() == 401) {
            throw TaqnyatRequestException::unAuthorized();
        }

        if (! $response->successful()) {
            throw TaqnyatRequestException::unknownError($response->json()['message'], $response->status());
        }

        return SystemStatusDto::fromArray($response->json());
    }

    /**
     * This method sends an SMS message to the specified recipients.
     *
     * This method sends a POST request to the API to send an SMS message
     * to the specified recipients. The method returns a MessageDataDto
     * object containing the response data.
     *
     * @param  string  $content  The content of the message to be sent.
     * @param  array|string  $recipients  The phone numbers of the recipients.
     * @return MessageDataDto The response data from the API.
     *
     * @throws ConnectionException
     * @throws TaqnyatRequestException
     */
    public function sendMsg(string $content, array|string $recipients): MessageDataDto
    {
        if (is_array($recipients)) {
            $recipients = implode(',', $recipients);
        }

        $response = $this->httpClient->post(
            url: $this->url('v1/messages'),
            data: [
                'body' => $content,
                'recipients' => $recipients,
                'sender' => $this->getSenderName(),
            ],
        );
        if ($response->status() == 401) {
            throw TaqnyatRequestException::unAuthorized();
        }
        if (! $response->successful()) {
            throw TaqnyatRequestException::unknownError($response->json()['message'], $response->status());
        }

        return MessageDataDto::fromArray($response->json());
    }

    /**
     * This method retrieves the account balance.
     *
     * This method sends a GET request to the API to retrieve the account balance.
     * If the request is successful, the method returns an AccountBalanceDto object
     * containing the response data.
     *
     * @return AccountBalanceDto The response data from the API.
     *
     * @throws ConnectionException
     * @throws TaqnyatRequestException
     */
    public function getAccountBalance(): AccountBalanceDto
    {
        $response = $this->httpClient->get(
            url: $this->url('account/balance')
        );

        if ($response->status() == 401) {
            throw TaqnyatRequestException::unAuthorized();
        }

        if (! $response->successful()) {
            throw TaqnyatRequestException::unknownError($response->json()['message'], $response->status());
        }

        if (isset($response->json()['ResponseStatus']) && $response->json()['ResponseStatus'] == 'fail') {
            throw TaqnyatRequestException::unknownError($response->json()['Error']['MessageEn'], $response->status());
        }

        return AccountBalanceDto::fromArray($response->json());
    }

    /**
     * Sets the sender name to the advertisement name.
     *
     * This method modifies the sender name by appending '-AD'
     * to the current sender name, indicating that the message
     * is for advertisement purposes.
     *
     * It is mandatory to comply with the regulations of Communications and Information Technology Commission (CST).
     *
     * @return $this
     */
    public function asAdvertisement(): self
    {
        $this->senderName = $this->getSenderAdvertisementName();

        return $this;
    }

    /**
     * Retrieves the sender name.
     *
     * @return string The sender name used for sending SMS messages.
     */
    public function getSenderName(): string
    {
        return $this->senderName;
    }

    /**
     * Retrieves the advertisement sender name.
     *
     * This method appends '-AD' to the current sender name to indicate
     * that the message is for advertisement purposes.
     *
     * @return string The modified sender name for advertisements.
     */
    public function getSenderAdvertisementName(): string
    {
        return $this->senderName.'-AD';
    }

    /**
     * Retrieves the API endpoint.
     *
     * @return string The API endpoint used for sending SMS requests.
     */
    public function getEndpoint(): string
    {
        return $this->endpoint;
    }

    /**
     * Retrieves the API token.
     *
     * @return string The token used for authenticating requests to the API.
     */
    public function getToken(): string
    {
        return $this->token;
    }

    private function url(string $path): string
    {
        return "{$this->endpoint}/{$path}";
    }
}
