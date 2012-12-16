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
        'path' => '/rest/'
    );

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
    }

    /**
     * Change any of the default options
     *
     * @param array $options
     */
    public function setOptions(array $options = array())
    {
        $this->options = array_merge($this->defaults, $options);
        $this->setApi();
    }

    private function setApi()
    {
        $api = sprintf(
            '%s://' . $this->options['host'] . ':' . $this->options['port'] . $this->options['path'],
            $this->options['secure'] ? 'https' : 'http'
        );
        $this->api = $api;
    }

    protected function get($resource)
    {
        $request  = new Request('GET', $resource, $this->api);
        $response = new Response();

        $request->addHeader('Accept: application/json');

        $client = new Curl();
        $client->send($request, $response);
        return $response;
    }

    protected function post($resource, $content)
    {
        $request  = new Request('POST', $resource, $this->api);
        $response = new Response();

        $request->addHeader('Content-Type: application/json; charset=UTF-8');
        $request->setContent($content);

        $client = new Curl();
        $client->send($request, $response);
        return $response;
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