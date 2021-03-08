<?php


namespace PcWeb\BitrixApi\Request;


use Illuminate\Http\Client\PendingRequest;
use PcWeb\BitrixApi\Exceptions\BitrixException;
use PcWeb\BitrixApi\Response\BitrixResponseFactory;

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

    public function timeout(int $timeout)
    {
        $this->httpRequest->timeout($timeout);
        return $this;
    }

    public function retry(int $times, int $sleep = null)
    {
        $this->httpRequest->retry($times, $sleep);
        return $this;
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

        return $this->responseFactory->responseFromJson($this, $httpResponse->json());
    }


    public function getArg(string $key, $default = null)
    {
        return data_get($this->args, $key, $default);
    }

    public function arg(string $key, $value)
    {
        $this->args[$key] = $value;
        return $this;
    }

    public function select(array $array)
    {
        return $this->arg('select', $array);
    }

    public function __call(string $method, array $args)
    {
        return $this->arg($method, $args[0]);
    }

    /**
     * @return array
     */
    public function getArgs(): array
    {
        return $this->args;
    }

    /**
     * @return string
     */
    public function getMethod(): string
    {
        return $this->method;
    }


}
