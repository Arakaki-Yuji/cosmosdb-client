<?php

namespace CosmosdbClient;

use GuzzleHttp\Client;
use CosmosdbClient\Core;

class Collection {
    private $core;

    public function __construct(Core $core)
    {
        $this->core = $core;
    }

    public function create($dbId, $collId, $indexingPolicy = null, $partitionKey = null)
    {
        $headers = $this->core->getAuthHeaders('POST', 'colls', 'dbs/'.$dbId);
        $baseUri = $this->core->makeBaseUri();
        $resourceUri = $baseUri . '/dbs/' . $dbId . '/colls';
        $body = [
            'id' => $collId
        ];
        if($indexingPolicy){
            $body['indexingPolicy'] = $indexingPolicy;
        }
        if($partitionKey){
            $body['partitionKey'] = $partitionKey;
        }
        $options = [
            'headers' => $headers,
            'body' => json_encode($body)
        ];
        return $this->core->request('POST', $resourceUri, $options);
    }

    public function get($dbId, $collId)
    {
        $headers = $this->core->getAuthHeaders('GET', 'colls', 'dbs/'.$dbId.'/colls/'.$collId);
        $baseUri = $this->core->makeBaseUri();
        $resourceUri = $baseUri . '/dbs/' . $dbId . '/colls/'.$collId;
        $options = [
            'headers' => $headers,
        ];
        return $this->core->request('GET', $resourceUri, $options);
    }

    public function list($dbId){
        $headers = $this->core->getAuthHeaders('GET', 'colls', 'dbs/'.$dbId);
        $baseUri = $this->core->makeBaseUri();
        $resourceUri = $baseUri . '/dbs/' . $dbId . '/colls';
        $options = [
            'headers' => $headers
        ];
        return $this->core->request('GET', $resourceUri, $options);
    }

    public function delete($dbId, $collId)
    {
        $headers = $this->core->getAuthHeaders('DELETE', 'colls', 'dbs/'.$dbId.'/colls/'.$collId);
        $baseUri = $this->core->makeBaseUri();
        $resourceUri = $baseUri . '/dbs/'.$dbId.'/colls/'.$collId;
        $options = [
            'headers' => $headers
        ];
        $res = $this->core->request('DELETE', $resourceUri, $options);
        return is_null($res);
    }

    public function replace($dbId, $collId, $indexingPolicy){
        $resourceLink = 'dbs/'.$dbId.'/colls/'.$collId;
        $headers = $this->core->getAuthHeaders('PUT', 'colls', $resourceLink);
        $baseUri = $this->core->makeBaseUri();
        $resourceUri = $baseUri . '/' . $resourceLink;
        $body = [
            'id' => $collId,
            'indexingPolicy' => $indexingPolicy
        ];
        $options = [
            'headers' => $headers,
            'body' => json_encode($body)
        ];
        return $this->core->request('PUT', $resourceUri, $options);
    }

    public function getPartitionkeyRanges($dbId, $collId, $paritionkeyrangeid = null)
    {
        $resourceLink = 'dbs/'.$dbId.'/colls/'.$collId ;
        $headers = $this->core->getAuthHeaders('GET', 'pkranges', $resourceLink);
        if($paritionkeyrangeid){
            $headers['x-ms-documentdb-partitionkeyrangeid'] = $paritionkeyrangeid;
        }
        $baseUri = $this->core->makeBaseUri();
        $resourceUri = $baseUri . '/' . $resourceLink .'/pkranges';
        $options = [
            'headers' => $headers,
        ];
        return $this->core->request('GET', $resourceUri, $options);
    }
}
