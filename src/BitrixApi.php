<?php

namespace PcWeb\BitrixApi;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Http;
use PcWeb\BitrixApi\Request\BatchRequest;
use PcWeb\BitrixApi\Request\BitrixRequest;
use PcWeb\BitrixApi\Response\BitrixResponseFactory;

class BitrixApi
{
    protected BitrixSettings $settings;
    protected BitrixResponseFactory $responseFactory;
    protected Client $client;

    /**
     * Bitrix constructor.
     * @param BitrixSettings $settings
     * @param BitrixResponseFactory $responseFactory
     */
    public function __construct(BitrixSettings $settings, BitrixResponseFactory $responseFactory)
    {
        $this->settings = $settings;
        $this->responseFactory = $responseFactory;
    }

    public function request(string $method, ?array $args = [])
    {
        return (new BitrixRequest(
            Http::baseUrl($this->settings->webhookUrl)
                ->timeout($this->settings->timeout)
                ->asJson(),
            $this->responseFactory
        ))
            ->method($method)
            ->args($args);
    }

    public function batch(iterable $requests)
    {
        return (new BatchRequest(
            Http::baseUrl($this->settings->webhookUrl)->asJson(),
            $this->responseFactory
        ))->build($requests);
    }

    public function call($method, $args = [])
    {
        return $this->request($method, $args);
    }
}
