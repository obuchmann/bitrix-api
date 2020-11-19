<?php


namespace PcWeb\BitrixApi\Response;


use Illuminate\Support\Collection;

class BitrixEntry extends Collection
{
    public function __get($prop)
    {
        return $this->get($prop);
    }
}
