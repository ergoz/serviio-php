<?php

namespace Serviio;

class Configuration extends Serviio
{

    public function getServiceStatus()
    {
        return $this->client->get('/service-status');
    }

    public function getLibraryStatus()
    {
        return $this->client->get('/library-status');
    }

    public function getStatus()
    {
        return $this->client->get('/status');
    }

    // TODO not sure how this used and how it should be handled.
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
        return $this->client->put('/status', $data);
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
        return $this->get('/refdata/'.$property);
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

        return $this->client->post('/action', $data);
    }
}
