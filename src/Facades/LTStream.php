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
 * @method static mixed  addMonitor($name,$path,$subPath,$address)
 * @method static mixed updateMonitor ($code,$name,$path,$subPath,$address);
 * @method static mixed getMonitorList();
 * @method static mixed getMonitorPaginate($page = 1,$pageSize = 15);
 * @method static mixed deleteMonitor($code);
 * @method static mixed getMonitorInfo($code);
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
