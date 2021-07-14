<?php


namespace Obuchmann\BitrixApi\Response;

use Illuminate\Support\Enumerable;
use Obuchmann\BitrixApi\Request\BitrixRequest;

interface BitrixResponse extends \ArrayAccess, Enumerable
{
    public function getRequest(): BitrixRequest;
}
