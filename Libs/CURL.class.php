<?php

class CURL {
    private $url;
    private $data;
    private $opts;
    
    function __construct($url) {
        $this->url = $url;
        $this->opts = [
            CURLOPT_POST => 1,
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_SSL_VERIFYPEER => FALSE,
            CURLOPT_SSL_VERIFYHOST => FALSE,
        ];
    }
    
    public function exec(){
        $ch = curl_init();
        $this->opts[CURLOPT_URL] = $this->url;
        $this->opts[CURLOPT_POSTFIELDS] = $this->data;
        
        curl_setopt_array($ch, $this->opts);
        $result = curl_exec($ch);
        
        if($result === false) {
            $err = curl_error($ch);
            curl_close ($ch);
            throw  new Exception( $err );
        }
        
        print_r(curl_getinfo($ch));
        die;
        curl_close ($ch);
        
        return $result;
    }
    
    public function setData($key, $value){
        $this->data[$key] = $value;
        return $this;
    }
    
    public function setFile($key, $value){
        if (filter_var($value, FILTER_VALIDATE_URL) === FALSE) {
            $this->data[$key] = '@'.$value;
        }else{
            $this->data[$key] = $value;
        }
        return $this;
    }
}