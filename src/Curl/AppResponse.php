<?php 

namespace Apolinux\Curl;

use SimpleXMLElement;

class AppResponse{
  public $response ;

  public function __construct($response){
    $this->response = $response ; 
  }
  
  /**
   * converts string to structure 
   * 
   * uses json_decode
   *
   * @param  bool $associative
   * @param  int $depth
   * @param  int $flags
   * @return mixed
   * @see https://php.net/manual/en/function.json-decode.php
   */
  public function toJson($associative = null, $depth = 512, $flags = 0){
    return json_decode($this->response, $associative, $depth, $flags);
  }

  public function __toString()
  {
    return (string)$this->response ;
  }

    
  /**
   * converts string to xml
   *
   * uses simplexml_load_string
   * 
   * @param $class_name 
   * @param $options 
   * @param $namespace_or_prefix
   * @param $is_prefix
   * @return SimpleXMLElement|false
   * @see https://php.net/manual/en/function.simplexml-load-string.php
   */
  public function toXml(
    ?string $class_name = "SimpleXMLElement",
    int $options = 0,
    string $namespace_or_prefix = "",
    bool $is_prefix = false
    ){
    return simplexml_load_string(
      $this->response, 
      $class_name, 
      $options, 
      $namespace_or_prefix, 
      $is_prefix);

  }
}