<?php

namespace Apolinux\Curl;

/**
 * Curl methods to make post/get request sending plain, json, xml or other doc types
 *
 * @author drake
 */
class Curl {

    /**
     * options to define in curl
     * @var array
     */
    private $curl_options ;

    /**
     * class constructor
     * set curl options
     *
     * @param array $curl_options curl options
     */
    public function __construct($curl_options = []) {
        $this->curl_options = $curl_options;
    }

    /**
     * send HTTP POST using JSON
     * @param string $url
     * @param array|object|string $data
     * @param float $timeout
     * @return Response
     */
    public function postJson($url,$data, $content_type='application/json', ?float $timeout=null)
    {
        $data1 = $data ;
        if(is_array($data) or is_object($data)){
            $data1 = json_encode($data) ;
        }
        $ch = curl_init();
        $curl_options0 = [
            CURLOPT_POST => true ,
            CURLOPT_POSTFIELDS => $data1,
            CURLOPT_RETURNTRANSFER => true ,
            CURLOPT_URL => $url ,
            CURLOPT_HEADER =>  true,
            CURLOPT_HTTPHEADER => [
                "content-type: $content_type",
            ] ,
        ];

        return $this->genericCall($ch, $data, $url, $curl_options0, $timeout);
    }

    /**
     * split raw http response body into headers and body
     * @param string $header
     * @return array
     */
    protected function convertHeader($header){
        $header_list = explode("\r\n",$header);
        $out = [];
        $cont=0;
        foreach($header_list as $line){
            if($cont++ == 0){
                $out['http_code'] = $line ;
                continue ;
            }
            if(empty($line)){
                continue;
            }
            $hfields = explode(": ",$line,2);
            if(isset($hfields[0])){
                $out[strtolower($hfields[0])] = (isset($hfields[1]) ? $hfields[1] : null);
            }
        }

        return $out ;
    }

    /**
     * send HTTP Post using XML format
     * @param string $url
     * @param string $data
     * @param float $timeout
     * @return Response
     */
    public function postXml($url,$data, $content_type = 'application/xml', ?float $timeout=null)
    {
        $ch = curl_init();
        $curl_options0 = [
            CURLOPT_POST => true ,
            CURLOPT_POSTFIELDS => $data,
            CURLOPT_RETURNTRANSFER => true ,
            CURLOPT_URL => $url ,
            CURLOPT_HEADER =>  true,
            CURLOPT_HTTPHEADER => [
                "content-type: $content_type",
            ] ,
        ];

        return $this->genericCall($ch, $data, $url, $curl_options0, $timeout);
    }

    /**
     * call curl exec and creates response object
     * 
     * @param resource|\CurlHandle $ch
     * @param mixed $data
     * @param string $url
     * @param array $curl_options
     * @param float $timeout
     * @return Response
     */
    private function genericCall($ch, $data, string $url, array $curl_options, float $timeout=null){
        $curl_options = array_merge_index($curl_options ,$this->curl_options) ;
        if(! empty($timeout)){
            $curl_options[CURLOPT_TIMEOUT] = $timeout ;
        }
        curl_setopt_array($ch,$curl_options);

        $raw_response = curl_exec($ch);

        $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
        $header_list = $this->convertHeader(substr($raw_response, 0, $header_size));
        $response = substr($raw_response, $header_size);

        $result = new Response(
            $data, 
            $response, 
            $header_list, 
            new DetailResponse($ch),
            $url
        );
        
        curl_close($ch);
        return $result ;
    }

    /**
     * Send HTTP Raw POST
     * @param string $url
     * @param string|array|object $data
     * @param float $timeout
     * @return Response
     */
    public function postRaw(
        $url, 
        $data, 
        $content_type = 'application/x-www-form-urlencoded', 
        ?float $timeout=null)
    {
        if(is_array($data) or is_object($data)){
            $data1 = http_build_query($data);
        }else{
            $data1 = $data ;
        }

        $ch = curl_init();
        $curl_options0 = [
            CURLOPT_POST => true ,
            CURLOPT_POSTFIELDS => $data1,
            CURLOPT_RETURNTRANSFER => true ,
            CURLOPT_URL => $url ,
            CURLOPT_HEADER =>  true,
            CURLOPT_HTTPHEADER => [
                "content-type: $content_type",
            ] ,
        ];

        return $this->genericCall($ch, $data, $url, $curl_options0, $timeout);
    }

    /**
     * make and HTTP get request JSON by default
     * @param string $url
     * @param string|object|array $data
     * @param float $timeout
     * @return Response
     */
    public function get($url,$data=null, $content_type='text/plain', ?float $timeout=null)
    {
        $data1 = $data ;
        if(is_array($data) or is_object($data)){
            $data1 = http_build_query($data) ;
        }
        $ch = curl_init();
        $headers = [
            "content-type: $content_type",
        ];

        if ( ! empty($data1) ){
            $url1 = $url . '?' . $data1 ;
        }else{
            $url1 = $url ;
        }

        $curl_options0 = [
            CURLOPT_RETURNTRANSFER => true ,
            CURLOPT_URL => $url1 ,
            CURLOPT_HEADER =>  true,
            CURLOPT_HTTPHEADER => $headers ,
        ];

        return $this->genericCall($ch, $data, $url1, $curl_options0, $timeout);
    }
}
