<?php


namespace PcWeb\BitrixApi\Response;


use Illuminate\Support\Collection;
use PcWeb\BitrixApi\Request\BitrixRequest;

class BitrixEntry extends Collection implements BitrixResponse
{
    public function __get($prop)
    {
        return $this->get($prop);
    }

    protected BitrixRequest $request;

    /**
     * @return BitrixRequest
     */
    public function getRequest(): BitrixRequest
    {
        return $this->request;
    }

    /**
     * @param BitrixRequest $request
     */
    public function setRequest(BitrixRequest $request): void
    {
        $this->request = $request;
    }

}
