<?php

trait tunnel {
    public function encrypt($data){
        if(!$this->token) $this->token = uniqid();
        return openssl_encrypt($data, 'aes128', $this->token);
    }

    public function decrypt($data){
        return openssl_decrypt($data, 'aes128', $this->token);
    }
}

trait common_mixin {
    public function getID(){
        return $this->id;
    }

    public function getToken(){
        return $this->token;
    }

    protected function setToken($token){
        // $this->token = $token;
        // FIXME: 重新生成加密内容
    }

    public function getMobile(){
        return $this->decrypt($this->mobile);
    }

    public function setMobile($mobile){
        $this->mobile = $this->encrypt($mobile);
    }
}

trait car_mixin {
    public function getName(){
        return $this->decrypt($this->name);
    }

    public function setName($name){
        $this->name = $this->encrypt($name);
    }

    public function getTime(){
        return $this->creation_time;
    }

    public function setTime($time=null){
        if(!$time) $time = new DateTime('now');
        $this->creation_time = $time;
    }

    public function getCarInfo(){
        $hpzl = $this->decrypt($this->hpzl);
        $hphm = $this->decrypt($this->hphm);
        return array($hpzl, $hphm);
    }

    public function setCarInfo($hpzl, $hphm){
        $this->hpzl = $this->encrypt($hpzl);
        $this->hphm = $this->encrypt($hphm);
    }
}

trait driver_mixin {
    public function getName(){
        return $this->decrypt($this->name);
    }

    public function setName($name){
        $this->name = $this->encrypt($name);
    }

    public function getTime(){
        return $this->creation_time;
    }

    public function setTime($time=null){
        if(!$time) $time = new DateTime('now');
        $this->creation_time = $time;
    }

    public function getDriverInfo(){
        return $this->decrypt($this->jszh);
    }

    public function setDriverInfo($jszh){
        $this->jszh = $this->encrypt($jszh);
    }
}

trait sms_mixin {
    public function setContent($content){
        $this->content = $this->encrypt($content);
    }

    public function getContent(){
        return $this->decrypt($this->content);
    }

    public function setTime($time=null){
        if(!$time) $time = new DateTime('now');
        $this->send_time = $time;
    }

    public function getTime(){
        return $this->send_time;
    }

    public function add($mobile, $content){
        $this->setContent($content);
        $this->setMobile($mobile);
        $this->setTime();
    }
}

trait sms_hash_mixin {
    public function getType(){
        return $this->type;
    }

    public function getTime(){
        return $this->creation_time;
    }

    public function add($type, $mobile, $hash){
        $this->type = $type;
        $this->mobile = $mobile;
        $this->hash = $hash;
        $this->creation_time = new DateTime('now');
    }
}
