<?php
/**
 * Created by PhpStorm.
 * User: wanghouting
 * Date: 2019-11-13
 * Time: 09:57
 */

namespace LTStream\Extension\Support;


use http\Exception\RuntimeException;

abstract class  AbstractStreamBasic {

    protected $local_address;//内网地址
    protected $public_address;//外网地址
    protected $app_access_key;//key
    protected $app_secret;//秘钥
    protected $version = 'v1';//版本
    protected $mode = 'production';


    public function __construct() {
        !$this->local_address && $this->throw('未设置$local_address');
        !$this->public_address && $this->throw('未设置$public_address');
        !$this->app_access_key && $this->throw('未设置$app_access_key');
        !$this->app_secret && $this->throw('未设置$app_secret');
    }

    protected function throw($msg) {
        throw new RuntimeException($msg);
    }

    public function getLocalAddress() {
        return $this->local_address;
    }

    public function getPublicAddress() {
        return $this->getPublicAddress();
    }

    public function getAppAccessKey() {
        return $this->app_access_key;
    }

    public function getAppSecret() {
        return $this->getAppSecret();
    }

    public function getVersion() {
        return $this->version;
    }

    public function getMode() {
        return $this->mode;
    }
}