<?php

use PHPUnit\Framework\TestCase as PHPUnit_Framework_TestCase ;
use Apolinux\Curl;

class CurlTest extends PHPUnit_Framework_TestCase {

    public function testPostJson(){
        $curl = new Curl;

        $url ='https://jsonplaceholder.typicode.com/posts' ;
        $request = [
          'name' => 'bla' ,
          'type' => 'fin',
        ];
        $response = $curl->postJson($url,$request) ;

        $this->assertEquals(0 , $response->curl->code) ;
        $this->assertEquals('No error' , $response->curl->message) ;
        $this->assertEquals(201 , $response->http_code) ;
        $this->assertEquals($url , $response->full_url) ;
        $this->assertEquals(201 , $response->curl->info['http_code']) ;
        $this->assertEquals($request, $response->request) ;
        $this->assertTrue(is_object($response->response->toJson())) ;
        $this->assertStringContainsString('application/json', $response->content_type);
    }

    public function testPostXml(){
        $curl = new Curl;

        $url ='https://jsonplaceholder.typicode.com/posts' ;
        $request = [
          'name' => 'bla' ,
          'type' => 'fin',
        ];
        $response = $curl->postXml($url,$request) ;

        $this->assertEquals(0 , $response->curl->code) ;
        $this->assertEquals('No error' , $response->curl->message) ;
        $this->assertEquals(201 , $response->http_code) ;
        $this->assertEquals($url , $response->full_url) ;
        $this->assertEquals(201 , $response->curl->info['http_code']) ;
        $this->assertEquals($request, $response->request) ;
        $this->assertTrue(is_object(json_decode($response->response))) ;
    }

    public function testPostRaw(){
        $curl = new Curl;

        $url ='http://httpbin.org/post' ;
        $request = 'asdfasdfalkjasdflgkj3woriwjeklasjlfknflkasjfdhasdfj';
        $response = $curl->postRaw($url,$request) ;

        $this->assertEquals(0 , $response->curl->code) ;
        $this->assertEquals('No error' , $response->curl->message) ;
        $this->assertEquals(200 , $response->http_code) ;
        $this->assertEquals($url , $response->full_url) ;
        $this->assertEquals(200 , $response->curl->info['http_code']) ;
        $this->assertEquals($request, $response->request) ;
        $this->assertTrue(is_object($response->response->toJson())) ;
    }

    public function testGet(){
        $curl = new Curl;

        $url ='http://httpbin.org/get' ;
        $request = 'x=1';
        $response = $curl->get($url,$request) ;

        $this->assertEquals(0 , $response->curl->code) ;
        $this->assertEquals('No error' , $response->curl->message) ;
        $this->assertEquals(200 , $response->http_code) ;
        $this->assertEquals($url.'?x=1' , $response->full_url) ;
        $this->assertEquals(200 , $response->curl->info['http_code']) ;
        $this->assertEquals($request, $response->request) ;
        $this->assertTrue(is_object($response->response->toJson())) ;
    }

    public function testGetCustomStatus(){
        $curl = new Curl;

        $url ='http://httpbin.org/status/504' ;
        $request = '' ;
        $response = $curl->get($url) ;

        $this->assertEquals(0 , $response->curl->code) ;
        $this->assertEquals('No error' , $response->curl->message) ;
        $this->assertEquals(504 , $response->http_code) ;
        //$this->assertEquals($url.'?x=1' , $response->full_url) ;
        $this->assertEquals($request, $response->request) ;
    }

    public function testGetNoParams(){
        $curl = new Curl;

        $url ='http://httpbin.org/get' ;
        $request = null;
        $response = $curl->get($url,$request) ;

        $this->assertEquals(0 , $response->curl->code) ;
        $this->assertEquals('No error' , $response->curl->message) ;
        $this->assertEquals(200 , $response->http_code) ;
        $this->assertEquals($url , $response->full_url) ;
        $this->assertEquals(200 , $response->curl->info['http_code']) ;
        $this->assertEquals($request, $response->request) ;
        $this->assertTrue(is_object($response->response->toJson())) ;
    }

    public function testGetXml(){
        $curl = new Curl;

        $url ='http://httpbin.org/xml' ;
        $request = null;
        $response = $curl->get($url,$request) ;

        $this->assertEquals(0 , $response->curl->code) ;
        $this->assertEquals('No error' , $response->curl->message) ;
        $this->assertEquals(200 , $response->http_code) ;
        $this->assertEquals($url , $response->full_url) ;
        $this->assertEquals(200 , $response->curl->info['http_code']) ;
        $this->assertEquals($request, $response->request) ;
        $this->assertInstanceOf(SimpleXMLElement::class, $response->response->toXml()) ;
        $this->assertStringContainsString('application/xml',$response->content_type);
    }

    public function testGetHttps(){
        $curl = new Curl;

        $url ='https://httpbin.org/get' ;
        $request = 'x=1';
        $response = $curl->get($url,$request) ;

        $this->assertEquals(0 , $response->curl->code) ;
        $this->assertEquals('No error' , $response->curl->message) ;
        $this->assertEquals(200 , $response->http_code) ;
        $this->assertEquals($url.'?x=1' , $response->full_url) ;
        $this->assertEquals(200 , $response->curl->info['http_code']) ;
        $this->assertEquals($request, $response->request) ;
        $this->assertTrue(is_object($response->response->toJson())) ;
    }
}
