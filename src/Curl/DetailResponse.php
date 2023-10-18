<?php

namespace Apolinux\Curl;

/**
 * Curl information
 *
 * @author drake
 */
class DetailResponse {
    /**
     * error code
     * @var int
     */
    public $code ;

    /**
     * Error message
     * @var string
     */
    public $message ;

    /**
     * Curl info after request
     * @see http://php.net/manual/en/function.curl-getinfo.php
     * @var array
     */
    public $info ;

    /**
     * response of curl_exec
     * @var string
     */
    public $response ;

    /**
     * class construct 
     * 
     * @param \CurlHandle|handle $curl curl resource 
     * @param string $response response of curl_exec
     */
    public function __construct(
        $curl ,
        string $response
        ) {
        $this->code     = curl_errno($curl) ;
        $this->message  = curl_strerror($this->code) ;
        $this->info     = curl_getinfo($curl);
        $this->response = $response ;
    }
}
