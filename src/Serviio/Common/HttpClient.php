<?php

namespace Serviio\Common;

use Buzz\Client\Curl;
use Buzz\Message\Request;
use Buzz\Message\Response;

class HttpClient
{

    const METHOD_GET = 'GET';
    const METHOD_POST = 'POST';
    const METHOD_PUT = 'PUT';

    const HEADER_ACCEPT = 'Accept: application/json';
    const HEADER_CONTENT_TYPE = 'Content-Type: application/json; charset=UTF-8';

    private $api = null;

    public function __construct($uri)
    {
        $this->api = sprintf(
            '%s://' . $uri['host'] . ':' . $uri['port'] . $uri['service'],
            $uri['secure'] ? 'https' : 'http'
        );
    }

    private function request($method, $resource, $headers = array(), $content = null)
    {
        $request  = new Request($method, $resource, $this->api);
        $response = new Response();

        $request->addHeader(self::HEADER_ACCEPT);
        if(!empty($headers)){
            $request->addHeaders($headers);
        }

        if(!is_null($content)){
            $request->setContent(json_encode($content));
        }

        $client = new Curl();
        $client->send($request, $response);
        return $response;
    }

    public function get($resource)
    {
        return $this->request(self::METHOD_GET, $resource);
    }

    public function post($resource, $content)
    {
        $headers = array(self::HEADER_CONTENT_TYPE);
        return $this->request(self::METHOD_POST, $resource, $headers, $content);
    }

    public function put($resource, $content)
    {
        $headers = array(self::HEADER_CONTENT_TYPE);
        return $this->request(self::METHOD_PUT, $resource, $headers, $content);
    }
}