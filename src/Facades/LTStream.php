<?php

namespace LTStream\Extension\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Class LTStream
 * @author wanghouting
 * @method static string getToken()
 * @package LTStream\Extension\Facades
 */
class LTStream extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return \LTStream\Extension\Support\LTStream::class;
    }
}
