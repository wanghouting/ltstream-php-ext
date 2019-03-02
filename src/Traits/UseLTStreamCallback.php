<?php
namespace LTStream\Extension\Traits;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;

/**
 * Trait UseLTStreamCallback
 * @author wanghouting
 * @package LTStream\Extension\Traits
 */
trait UseLTStreamCallback {
    public function callback(Request $request) {
        $code = Cache::get($request->get("request_id",'')) ? 200 : 422;
        return  response()->json(['code'=>$code],200);
    }
}