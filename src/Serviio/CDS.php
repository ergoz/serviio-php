<?php

namespace Serviio;

class CDS extends Serviio
{
    public function __construct(array $options = array())
    {
        $options = array_merge($options, array('service' => '/cds/', 'port' => '23424'));
        parent::__construct($options);
    }
}
