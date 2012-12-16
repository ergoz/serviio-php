<?php

namespace Serviio;

class Configuration extends Serviio
{

    public function getStatus()
    {
        return $this->get('status');
    }

    public function getServiceStatus()
    {
        return $this->get('service-status');
    }

    public function getLibraryStatus()
    {
        return $this->get('library-status');
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
