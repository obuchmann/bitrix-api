<?php


namespace Obuchmann\BitrixApi\Request;


use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Collection;
use Obuchmann\BitrixApi\Exceptions\BitrixException;
use Obuchmann\BitrixApi\Response\BitrixCollection;
use Obuchmann\BitrixApi\Response\BitrixResponseFactory;

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

    public function get()
    {
        return $this->getResponse();
    }

    public function first()
    {
        $response = $this->getResponse();
        if($response) return $response->first();
        return null;
    }

    public function stream()
    {
        do {
            $response = $this->getResponse();
            if(null == $response){
                $emptyResponse =  new BitrixCollection();
                $emptyResponse->setRequest($this);
                yield $emptyResponse;
                break;
            }
            yield $response;
            $this->arg('start', $response->start + 50);
        }
        while($response->next && $response->start < $response->total);
    }

    public function all()
    {
        return array_reduce(iterator_to_array($this->stream()), fn (Collection $carry, Collection $item) => $carry->concat($item), new Collection());
    }

    public function getResponse()
    {
        $httpResponse = $this->httpRequest->post($this->method . '.json', $this->args);
        if (!$httpResponse->successful()) {
            try{
                $error = $httpResponse->json();

                if(isset($error['error'])){
                    if(isset($error['error_description'])){
                        throw new BitrixException("Invalid Response Code " . $httpResponse->status() . ' error: '. $error['error'] . ' => ' . $error['error_description'], $httpResponse->status());
                    }else{
                        throw new BitrixException("Invalid Response Code " . $httpResponse->status() . ' error: '. $error['error'], $httpResponse->status());
                    }
                }
            }catch (\Exception $e){}

            throw new BitrixException("Invalid Response Code ". $httpResponse->status(). ' message: ' . $httpResponse->body(), $httpResponse->status());
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

    public function filter($array)
    {
        return $this->arg('filter', $array);
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
