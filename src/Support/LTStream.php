<?php
namespace LTStream\Extension\Support;

use Illuminate\Support\Facades\Cache;
use LTStream\Extension\Exception\LTStreamNetworkingException;

/**
 * Class LTStream
 * @author wanghouting
 * @package LTStream\Extension\Support
 */
class LTStream {
    protected $config;
    protected $httpClient;

    public function __construct() {
        $this->config = config('ltstream');
        $this->httpClient = new \GuzzleHttp\Client(
            [
                'verify' => false,
                'base_uri' => $this->config['server'],
                'timeout'  => 5.0,
                'headers' => [
                    'Content-Type' => 'application/x-www-form-urlencoded',
                    'Version'    => $this->config['version']
                ],
            ]);
    }

    /**
     * 获取token
     * @return mixed
     * @throws LTStreamNetworkingException
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @deprecated please using LTStream\Extension\Facades\LTStream::getToken()
     */
    public function getToken() {
        try{
            return \GuzzleHttp\json_decode($this->httpClient->request("post",'/api/third/get_token',[
                'form_params' =>['signature'=> $this->signature()]
            ])->getBody(),true);
        }catch (\Exception $e){
            throw new LTStreamNetworkingException("LTStream平台地址:" .$this->config['server'] . ",请求超时");
        }
    }

    /**
     * 生成签名
     * @return string
     */
    private function signature() {
        $signature = $this->generate_header() .'.'.$this->generate_payload();
        $md5Str = md5($signature.$this->config['app_secret']);
        return $signature .'.'.$md5Str;
    }

    /**
     * 生成payload
     * @return string
     */
    private function generate_payload(){
        return base64_encode(json_encode([
            'timestamp'     => time(),
            'sdk_key'       => str_random(),
            'ak'            =>  $this->config['app_access_key'],
        ]));
    }

    /**
     * 生成header
     * @return string
     */
    private function generate_header(){
        $request_id = $this->create_guid();
        //存入缓存，1分钟
        Cache::put($request_id,$request_id,1);
        return base64_encode(json_encode([
            'alg'           => "md5",
            'type'          => "jwt" ,
            'request_id'   => $request_id,
        ]));
    }

    /**
     * 生成唯一字符串
     * @param string $namespace
     * @return string
     */
    private function create_guid($namespace = '') {
        static $guid = '';
        $uid = uniqid("", true);
        $data = $namespace;
        $data .= $_SERVER['REQUEST_TIME'];
        $data .= $_SERVER['HTTP_USER_AGENT'];
        $data .= $_SERVER['SERVER_ADDR'];
        $data .= $_SERVER['SERVER_PORT'];
        $data .= $_SERVER['REMOTE_ADDR'];
        $data .= $_SERVER['REMOTE_PORT'];
        $hash = strtoupper(hash('ripemd128', $uid . $guid . md5($data)));
        return '{' .
            substr($hash,  0,  8) .
            '-' .
            substr($hash,  8,  4) .
            '-' .
            substr($hash, 12,  4) .
            '-' .
            substr($hash, 16,  4) .
            '-' .
            substr($hash, 20, 12) .
            '}';
    }
}