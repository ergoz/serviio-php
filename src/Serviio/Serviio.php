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
    private $defaults = array(
        'host'    => '127.0.0.1',
        'port'    => '23423',
        'secure'  => false,
        'service' => '/rest/'
    );

    protected $edition = null;

    protected $version = null;

    protected $license = null;

    /**
     * Contains all parts of the api url
     * @var array
     */
    protected $options = array();

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
        foreach(json_decode($response->getContent()) as $key => $value){
            $this->{$key} = $value;
        }
    }

    /**
     * Change any of the default options
     *
     * @param array $options
     */
    private function setOptions(array $options = array())
    {
        $this->options = array_merge($this->defaults, $options);
        $this->setApi();
    }

    private function setApi()
    {
        $api = sprintf(
            '%s://' . $this->options['host'] . ':' . $this->options['port'] . $this->options['service'],
            $this->options['secure'] ? 'https' : 'http'
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