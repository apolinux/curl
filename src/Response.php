<?php 

namespace Apolinux ;

class Response{
  /**
     * HTTP request information, could be string, array or object
     * @var mixed
     */
    public $request ;

    /**
     * HTTP response
     * @var AppResponse
     */
    public $response ;

    /**
     *  HTTP response headers
     * @var array
     */
    public $header_list ;

    /**
     * Curl response
     * @var CurlResponse
     */
    public $curl ;

    /**
     * HTTP response code
     * @var int
     */
    public $http_code ;

    /**
     * dest URL with query parameters
     * @var string
     */
    public $full_url ;

    /**
     * full duration of request
     * @var float
     */
    public $duration ;

    /**
     * content type 
     * @var string
     */
    public $content_type ;
        
    /**
     * __construct
     *
     * @param mixed         $request 
     * @param string        $response
     * @param array         $header_list
     * @param CurlResponse  $curl
     * @param string        $full_url
     * @return void
     */
    public function __construct(
      $request, 
      string $response, 
      array $header_list, 
      CurlResponse $curl, 
      string $full_url) {
        $this->request      = $request ;
        $this->response     = new AppResponse($response) ;
        $this->header_list  = $header_list ;
        $this->curl         = $curl ;
        $this->full_url     = $full_url ;
        $this->duration     = $this->curl->info['total_time'] ;
        $this->http_code    = $this->curl->info['http_code'] ;
        $this->content_type = $header_list['content-type'] ?? ''; 
    }
}