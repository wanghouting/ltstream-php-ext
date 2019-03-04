<?php

namespace LTStream\Extension\Controllers;

use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;


if (class_exists("\\Illuminate\\Routing\\Controller")) {
    class BaseController extends \Illuminate\Routing\Controller {}
} elseif (class_exists("Laravel\\Lumen\\Routing\\Controller")) {
    class BaseController extends \Laravel\Lumen\Routing\Controller {}
}


/**
 * 接口回调
 * Class LTStreamCallbackController
 * @author wanghouting
 */
class LTStreamCallbackController extends BaseController
{

    public function callback(Request $request) {
        $code = Cache::get($request->get("request_id",'')) ? 200 : 422;
        return  response()->json(['ltstream_code'=>$code],200);
    }

}