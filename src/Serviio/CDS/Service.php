<?php

namespace Serviio\CDS;

use Serviio\Common\AbstractService;

class Service extends AbstractService
{
    public function __construct($uri = array())
    {
        $uri = array_merge($uri, array('service' => '/cds', 'port' => '23424'));
        parent::__construct($uri);
    }
}
