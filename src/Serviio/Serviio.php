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
    protected $defaults = array(
        'host'    => '127.0.0.1',
        'port'    => '23423',
        'secure'  => false,
        'version' => '/rest/'
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
    protected $api;

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
            '%s://' . $this->options['host'] . ':' . $this->options['port'] . $this->options['version'],
            $this->options['secure'] ? 'https' : 'http'
        );
        $this->api = $api;
    }

    private function get($resource)
    {
        $request  = new Request('GET', $resource, $this->api);
        $response = new Response();

        $request->addHeader('Accept: application/json');

        $client = new Curl();
        $client->send($request, $response);
        return $response;
    }

    private function post($resource, $content)
    {
        $request  = new Request('POST', $resource, $this->api);
        $response = new Response();

        $request->addHeader('Content-Type: application/json; charset=UTF-8');
        $request->setContent($content);

        $client = new Curl();
        $client->send($request, $response);
        return $response;
    }

    public function getStatus()
    {
        return $this->get('status');
    }

    public function getPing()
    {
        return $this->get('ping');
    }

    public function action($operation, $parameters = null)
    {

        $data = array('name' => $operation);

        if (!is_null($parameters)) {
            $data += $parameters;
        }

        return $this->post('action', json_encode($data));
    }
}