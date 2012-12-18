<?php

namespace Serviio;

class CDS extends Serviio
{
    public function __construct($uri = array())
    {
        $uri = array_merge($uri, array('service' => '/cds', 'port' => '23424'));
        parent::__construct($uri);
    }
}
