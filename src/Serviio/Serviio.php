<?php

namespace Serviio;

use Buzz\Client\Curl;
use Buzz\Message\Request;
use Buzz\Message\Response;

class Serviio
{

    /**
     * @var array
     */
    private static $defaults = array(
        'host'    => '127.0.0.1',
        'port'    => '23423',
        'secure'  => false,
        'service' => '/rest/'
    );

    protected $data = null;

    /**
     * Contains all parts of the uri scheme
     * @var array
     */
    protected $uri = array();

    /**
     * Api url
     * @var string
     */
    protected $api = null;

    /**
     * @param array $options
     */
    public function __construct(array $options = array())
    {
        $this->setOptions($options);

        $response = $this->getApplication();
        $this->data = json_decode($response->getContent());
    }

    /**
     * Change any of the default options
     *
     * @param array $options
     */
    private function setOptions(array $options = array())
    {
        $this->uri = array_merge(self::$defaults, $options);
        $this->setApi();
    }

    private function setApi()
    {
        $api = sprintf(
            '%s://' . $this->uri['host'] . ':' . $this->uri['port'] . $this->uri['service'],
            $this->uri['secure'] ? 'https' : 'http'
        );
        $this->api = $api;
    }

    private function request($method, $resource, $headers = array(), $content = null)
    {
        $request  = new Request($method, $resource, $this->api);
        $response = new Response();

        $request->addHeader('Accept: application/json');
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

    protected function get($resource)
    {
        return $this->request('GET', $resource);
    }

    protected function post($resource, $content)
    {
        $headers = array('Content-Type: application/json; charset=UTF-8');
        return $this->request('POST', $resource, $headers, $content);
    }

    protected function put($resource, $content)
    {
        $headers = array('Content-Type: application/json; charset=UTF-8');
        return $this->request('PUT', $resource, $headers, $content);
    }

    public function getPing()
    {
        return $this->get('ping');
    }

    public function getApplication()
    {
        return $this->get('application');
    }
}