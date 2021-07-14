<?php


namespace Obuchmann\BitrixApi\Request;


use Illuminate\Support\Collection;
use Obuchmann\BitrixApi\Exceptions\BitrixException;

class BatchRequest extends BitrixRequest
{
    protected iterable $requests;
    protected string $method = "batch";

    public function each(callable $callback)
    {
        $rsp = $this->getResponse();

        $responses = $rsp->result;
        if (!empty($responses)) {
            foreach ($responses as $key => $response) {
                $request = $this->requests[$key];
                $callback($this->responseFactory->makeResponse($request, $response), $request);
            }
        }
    }

    public function map(callable $callback): Collection
    {
        $rsp = $this->getResponse();

        return $rsp->result->map(function ($response, $key) use ($callback) {
            $request = $this->requests[$key];
            return $callback($this->responseFactory->makeResponse($request, $response), $request);
        });
    }
    public function mapWithKeys(callable $callback)
    {
        $rsp = $this->getResponse();

        return $rsp->result->mapWithKeys(function ($response, $key) use ($callback) {
            $request = $this->requests[$key];
            return $callback($this->responseFactory->makeResponse($request, $response), $request);
        });
    }

    public function build(iterable $requests)
    {
        $this->requests = $requests;
        $cmds = [];
        /**
         * @var string $key
         * @var BitrixRequest $request
         */
        foreach ($requests as $key => $request) {
            if (is_numeric($key)) {
                throw new BitrixException("Unique Request key has to be given!");
            }
            $requestUri = $request->getMethod();

            $args = $request->getArgs();
            if (!empty($args)) {
                $requestUri .= '?' . http_build_query($args);
            }

            $cmds[$key] = $requestUri;
        }
        $this->args = [
            'cmd' => $cmds
        ];
        return $this;
    }


}
