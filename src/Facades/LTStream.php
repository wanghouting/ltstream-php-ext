<?php

namespace LTStream\Extension\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Class LTStream
 * @author wanghouting
 * @method static string getMainFlvLiveUrl($code)
 * @method static string getMainTsLiveUrl($code)
 * @method static string getSubFlvLiveUrl($code)
 * @method static string getSubTsLiveUrl($code)
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
