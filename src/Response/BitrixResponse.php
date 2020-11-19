<?php


namespace PcWeb\BitrixApi\Response;

use Illuminate\Support\Enumerable;
use PcWeb\BitrixApi\Request\BitrixRequest;

interface BitrixResponse extends \ArrayAccess, Enumerable
{
    public function getRequest(): BitrixRequest;
}
