<?php

namespace LTStream\Extension\Support;

use http\Exception\RuntimeException;
use Illuminate\Support\Facades\Cache;
use LTStream\Extension\Exception\LTStreamNetworkingException;
use LTStream\Extension\Exception\LTStreamTokenException;

/**
 * Class LTStream
 * @author wanghouting
 * @package LTStream\Extension\Support
 */
class LTStream {
    /**
     * @var AbstractStreamBasic
     */
    protected $config;
    protected $httpClient;

    public function __construct() {
        try {
            $this->config = app('ltstream');
        } catch (\Exception $e) {
            throw new RuntimeException('未定义app(\'ltstream\')');
        }

        if (!$this->config instanceof AbstractStreamBasic) {
            throw new RuntimeException("app('ltstream')实例必须继承自AbstractStreamBasic");
        }
        $this->httpClient = new \GuzzleHttp\Client(
            [
                'verify' => false,
                'base_uri' => $this->config->getLocalAddress(),
                'timeout' => 5.0,
                'headers' => [
                    'Content-Type' => 'application/x-www-form-urlencoded',
                    'Version' => $this->config->getVersion()
                ],
            ]);
    }

    /**
     * 获取token
     * @return mixed
     * @throws LTStreamNetworkingException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    private function getToken() {
        try {
            return \GuzzleHttp\json_decode($this->httpClient->request("post", '/api/third/get_token', [
                'form_params' => ['signature' => $this->signature()]
            ])->getBody(), true);
        } catch (\Exception $e) {
            throw new LTStreamNetworkingException("LTStream平台地址:" . $this->config->getLocalAddress() . ",请求超时");
        }
    }

    /**
     * @param $code 设备code
     * @param int $type
     * @param string $ext
     * @return string
     * @throws LTStreamNetworkingException
     * @throws LTStreamTokenException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    private function getLiveUrl($code, $type = 1, $ext = 'flv') {
        if ($this->config->getMode() == 'local') {
            return config('app.url') . '/video/' . mt_rand(1, 4) . '.mp4';
        }
        $token = $this->getToken();
        if ($token['code'] == 200) {
            $server = $this->config->getPublicAddress();
            return $server . '/live/' . $code . '.' . $ext . '?type=' . $type . '&token=' . $token['data']['token'];
        } else {
            throw new LTStreamTokenException("Token获取失败:" . $token['message']);
        }
    }

    /**
     * 获取flv主流播放地址
     * @param $code 设备code
     * @return string
     * @throws LTStreamNetworkingException
     * @throws LTStreamTokenException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getMainFlvLiveUrl($code) {
        return $this->getLiveUrl($code);
    }

    /**
     * 获取ts主流播放地址
     * @param $code 设备code
     * @return string
     * @throws LTStreamNetworkingException
     * @throws LTStreamTokenException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getMainTsLiveUrl($code) {
        return $this->getLiveUrl($code, 1, 'ts');
    }

    /**
     * 获取flv辅流播放地址
     * @param $code 设备code
     * @return string
     * @throws LTStreamNetworkingException
     * @throws LTStreamTokenException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getSubFlvLiveUrl($code) {
        return $this->getLiveUrl($code, 2);
    }

    /**
     * 获取ts辅流播放地址
     * @param $code
     * @return string
     * @throws LTStreamNetworkingException
     * @throws LTStreamTokenException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getSubTsLiveUrl($code) {
        return $this->getLiveUrl($code, 2, 'ts');
    }

    /**
     * 增加监控设备
     * @param $name  设备名称
     * @param $path  设备主流
     * @param $subPath 设备辅流
     * @param $address 设备地址
     * @return mixed
     * @throws LTStreamNetworkingException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function addMonitor($name, $path, $subPath, $address) {
        try {
            return \GuzzleHttp\json_decode($this->httpClient->request("post", '/api/third/monitor_add', [
                'form_params' => [
                    'signature' => $this->signature(),
                    'name' => $name,
                    'path' => $path,
                    'sub_path' => $subPath,
                    'address' => $address,
                ]
            ])->getBody(), true);
        } catch (\Exception $e) {
            throw new LTStreamNetworkingException("LTStream平台地址:" . $this->config->getLocalAddress() . ",请求超时");
        }
    }

    /**
     * 更新监控设备
     * @param $code 设备code
     * @param $name 设备名称
     * @param $path 设备主码流
     * @param $subPath 设备辅流
     * @param $address 设备地址
     * @return mixed
     * @throws LTStreamNetworkingException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function updateMonitor($code, $name, $path, $subPath, $address) {
        try {
            return \GuzzleHttp\json_decode($this->httpClient->request("post", '/api/third/monitor_update', [
                'form_params' => [
                    'signature' => $this->signature(),
                    'code' => $code,
                    'name' => $name,
                    'path' => $path,
                    'sub_path' => $subPath,
                    'address' => $address,
                ]
            ])->getBody(), true);
        } catch (\Exception $e) {
            throw new LTStreamNetworkingException("LTStream平台地址:" . $this->config->getLocalAddress() . ",请求超时");
        }
    }

    /**
     * 获取所有监控设备列表
     * @return mixed
     * @throws LTStreamNetworkingException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getMonitorList() {
        try {
            return \GuzzleHttp\json_decode($this->httpClient->request("post", '/api/third/monitor_list', [
                'form_params' => [
                    'signature' => $this->signature(),
                ]
            ])->getBody(), true);
        } catch (\Exception $e) {
            throw new LTStreamNetworkingException("LTStream平台地址:" . $this->config->getLocalAddress() . ",请求超时");
        }
    }

    /**
     * 分页获取监控设备
     * @param $page 第几页
     * @param $pageSize 每页多少条
     * @return mixed
     * @throws LTStreamNetworkingException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getMonitorPaginate($page = 1, $pageSize = 15) {
        try {
            return \GuzzleHttp\json_decode($this->httpClient->request("post", '/api/third/monitor_paginate', [
                'form_params' => [
                    'signature' => $this->signature(),
                    'page' => $page,
                    'page_size' => $pageSize,
                ]
            ])->getBody(), true);
        } catch (\Exception $e) {
            throw new LTStreamNetworkingException("LTStream平台地址:" . $this->config->getLocalAddress() . ",请求超时");
        }
    }

    /**
     * 删除设备
     * @param $code 设备code
     * @return mixed
     * @throws LTStreamNetworkingException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function deleteMonitor($code) {
        try {
            return \GuzzleHttp\json_decode($this->httpClient->request("post", '/api/third/monitor_delete', [
                'form_params' => [
                    'signature' => $this->signature(),
                    'code' => $code,
                ]
            ])->getBody(), true);
        } catch (\Exception $e) {
            throw new LTStreamNetworkingException("LTStream平台地址:" . $this->config->getLocalAddress() . ",请求超时");
        }
    }

    /**
     * 获取某个设备的详细信息
     * @param $code 设备code
     * @return mixed
     * @throws LTStreamNetworkingException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getMonitorInfo($code) {
        try {
            return \GuzzleHttp\json_decode($this->httpClient->request("post", '/api/third/monitor_info', [
                'form_params' => [
                    'signature' => $this->signature(),
                    'code' => $code,
                ]
            ])->getBody(), true);
        } catch (\Exception $e) {
            throw new LTStreamNetworkingException("LTStream平台地址:" . $this->config->getLocalAddress() . ",请求超时");
        }
    }

    /**
     * 生成签名
     * @return string
     */
    private function signature() {
        $signature = $this->generate_header() . '.' . $this->generate_payload();
        $md5Str = md5($signature . $this->config->getAppSecret());
        return $signature . '.' . $md5Str;
    }


    /**
     * 生成payload
     * @return string
     */
    private function generate_payload() {
        return base64_encode(json_encode([
            'timestamp' => time(),
            'sdk_key' => str_random(),
            'ak' => $this->config->getAppAccessKey(),
        ]));
    }

    /**
     * 生成header
     * @return string
     */
    private function generate_header() {
        $request_id = $this->create_guid();
        //存入缓存，1分钟
        Cache::put($request_id, $request_id, 1);
        return base64_encode(json_encode([
            'alg' => "md5",
            'type' => "jwt",
            'request_id' => $request_id,
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
            substr($hash, 0, 8) .
            '-' .
            substr($hash, 8, 4) .
            '-' .
            substr($hash, 12, 4) .
            '-' .
            substr($hash, 16, 4) .
            '-' .
            substr($hash, 20, 12) .
            '}';
    }
}