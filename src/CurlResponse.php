<?php

namespace Apolinux;

/**
 * Description of CurlResult
 *
 * @author drake
 */
class CurlResponse {
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

    public function __construct(
        $curl
        ) {
        $this->code  = curl_errno($curl) ;
        $this->message = curl_strerror($this->code) ;
        $this->info = curl_getinfo($curl);
    }
}
