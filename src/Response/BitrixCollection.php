<?php


namespace PcWeb\BitrixApi\Response;


use Illuminate\Support\Collection;

class BitrixCollection extends BitrixEntry implements BitrixResponse
{
    public ?int $next = null;
    public ?int $total;
    public ?int $start = 0;

    protected BitrixResponseTime $time;
}
