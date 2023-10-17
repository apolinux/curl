# Curl 

manage some HTTP methods to make requests using [curl](https://curl.se/docs/) library 
in [PHP](https://www.php.net/manual/en/book.curl.php).

## Instalation

```
compose require apolinux/curl
```

## Examples

```
<?php

$curl = new Curl();

$payload = ['fin' => 'this is a test','bla' => 'no more'] ;

$response = $curl->postJson('https://httpbin.org',$payload);

print($response->response->toJson());
// prints:
// Array
// (
//    [fin] => this is a test
//    [bla] => no more
// )

```

