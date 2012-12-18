<?php

namespace Serviio;

use Serviio\HttpClient;

class Serviio
{

    /**
     * @var array
     */
    private static $defaults = array(
        'host'    => '127.0.0.1',
        'port'    => '23423',
        'secure'  => false,
        'service' => '/rest'
    );

    protected $appInfo = null;

    /**
     * Http client
     * @var HttpClient
     */
    protected $client = null;

    /**
     * @param array      $uri
     * @param HttpClient $client
     */
    public function __construct(array $uri = array(), HttpClient $client = null)
    {
        $this->client = $client ? : new HttpClient(array_merge(self::$defaults, $uri));

        $response = $this->getApplication();
        $this->appInfo = json_decode($response->getContent());
    }

    protected function isPro()
    {
        if($this->appInfo->edition === 'PRO') {
            return true;
        }
        return false;
    }

    public function getPing()
    {
        return $this->client->get('/ping');
    }

    public function getApplication()
    {
        return $this->client->get('/application');
    }
}