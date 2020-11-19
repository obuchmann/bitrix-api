<?php


namespace PcWeb\BitrixApi\Request;


use PcWeb\BitrixApi\Response\BitrixResponseFactory;
use PcWeb\BitrixApi\Exceptions\BitrixException;
use Illuminate\Http\Client\PendingRequest;

class BitrixRequest
{
    protected array $args = [];
    protected string $method;
    protected PendingRequest $httpRequest;
    protected BitrixResponseFactory $responseFactory;

    /**
     * BitrixRequest constructor.
     * @param array $args
     * @param string $method
     * @param PendingRequest $httpRequest
     */
    public function __construct(PendingRequest $httpRequest, BitrixResponseFactory $responseFactory)
    {
        $this->httpRequest = $httpRequest;
        $this->responseFactory = $responseFactory;
    }

    public function method(string $method)
    {
        $this->method = $method;
        return $this;
    }

    public function args(?array $args)
    {
        $this->args = $args ?? [];
        return $this;
    }

    public function getResponse()
    {
        $httpResponse = $this->httpRequest->post($this->method . '.json', $this->args);
        if (!$httpResponse->successful()) {
            throw new BitrixException("Invalid Response Code " . $httpResponse->status(), $httpResponse->status());
        }

        return $this->responseFactory->makeResponse($this, $httpResponse->json());
    }


    public function arg(string $key, $default)
    {
        return data_get($this->args, $key, $default);
    }

    public function select(array $array)
    {
        $this->args['select'] = $array;
        return $this;
    }
}
