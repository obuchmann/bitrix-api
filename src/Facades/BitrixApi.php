<?php

namespace Obuchmann\BitrixApi\Facades;

use Illuminate\Support\Facades\Facade;
use Obuchmann\BitrixApi\Request\BatchRequest;
use Obuchmann\BitrixApi\Request\BitrixRequest;
use phpDocumentor\Reflection\Types\Static_;

/**
 * Class BitrixApi
 * @package Obuchmann\BitrixApi\Facades
 * @method static BitrixRequest request(string $method, array $args = [])
 * @method static BatchRequest batch(array $requests)
 *
 * @see \Obuchmann\BitrixApi\BitrixApi
 */
class BitrixApi extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return \Obuchmann\BitrixApi\BitrixApi::class;
    }
}
