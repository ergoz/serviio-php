<?php

namespace Serviio;

class Configuration extends Serviio
{

    public function getStatus()
    {
        return $this->get('status');
    }

    public function putStatus($renderers, $boundIPAddress = null)
    {
        if($this->version !== 'PRO') {
            foreach($renderers as $renderer){
                $renderers[$renderer] = array_merge($renderer, array('accessGroups' => 1));
            }
        }

        $data['renderers'] = $renderers;
        if(!is_null($boundIPAddress)){
            $data['boundIPAddress'] = $boundIPAddress;
        }
        return $this->put('status', $data);
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
     * @param array $parameters
     *
     * @return \Buzz\Message\Response
     */
    public function action($operation, $parameters = array())
    {
        $data = array('name' => $operation);

        if (!is_null($parameters)) {
            $data += $parameters;
        }

        return $this->post('action', $data);
    }
}
