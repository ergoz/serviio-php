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

    /**
     * @param      $operation
     * Available operations: forceVideoFilesMetadataUpdate, forceLibraryRefresh, forceOnlineResourceRefresh,
     *                          startServer, stopServer, exitServiio, advertiseService, checkStreamUrl
     * @param null $parameters
     *
     * @return \Buzz\Message\Response
     */
    public function action($operation, $parameters = null)
    {
        $data = array('name' => $operation);

        if (!is_null($parameters)) {
            $data += $parameters;
        }

        return $this->post('action', json_encode($data));
    }
}
