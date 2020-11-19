<?php

namespace PcWeb\BitrixApi\Facades;

use Illuminate\Support\Facades\Facade;
use PcWeb\BitrixApi\Request\BitrixRequest;

/**
 * Class BitrixApi
 * @package PcWeb\BitrixApi\Facades
 * @method static BitrixRequest request(string $method, array $args = [])
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
        return 'bitrixapi';
    }
}
