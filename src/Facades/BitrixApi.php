<?php

namespace PcWeb\BitrixApi\Facades;

use Illuminate\Support\Facades\Facade;
use PcWeb\BitrixApi\Request\BatchRequest;
use PcWeb\BitrixApi\Request\BitrixRequest;
use phpDocumentor\Reflection\Types\Static_;

/**
 * Class BitrixApi
 * @package PcWeb\BitrixApi\Facades
 * @method static BitrixRequest request(string $method, array $args = [])
 * @method static BatchRequest batch(array $requests)
 *
 * @see \PcWeb\BitrixApi\BitrixApi
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
        return \PcWeb\BitrixApi\BitrixApi::class;
    }
}
