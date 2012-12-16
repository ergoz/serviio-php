<?php

namespace Serviio;

class Configuration extends Serviio
{

    public function getServiceStatus()
    {
        return $this->get('service-status');
    }

    public function getLibraryStatus()
    {
        return $this->get('library-status');
    }

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

    /**
     * @param $property
     *
     * @return \Buzz\Message\Response
     *
     * Available properties:
     * cpu-cores, profiles, metadataLanguages, browsingCategoriesLanguages, descriptiveMetadataExtractors,
     * categoryVisibilityTypes, onlineRepositoryTypes, onlineContentQualities, accessGroups, remoteDeliveryQualities
     */
    public function getRefdata($property)
    {
        return $this->get('refdata/'.$property);
    }

    /**
     * @param      $operation
     * @param array $parameters
     *
     * @return \Buzz\Message\Response
     *
     * Available operations:
     * forceVideoFilesMetadataUpdate, forceLibraryRefresh, forceOnlineResourceRefresh,
     * startServer, stopServer, exitServiio, advertiseService, checkStreamUrl
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
