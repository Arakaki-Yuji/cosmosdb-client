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
        $client = new Client();
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
        $response = $client->request('POST', $resourceUri, $options);
        $body = $response->getBody();
        $bodyContentString = $body->getContents();
        return json_decode($bodyContentString, true);
    }

    public function get($dbId, $collId)
    {
        $headers = $this->core->getAuthHeaders('GET', 'colls', 'dbs/'.$dbId.'/colls/'.$collId);
        $baseUri = $this->core->makeBaseUri();
        $resourceUri = $baseUri . '/dbs/' . $dbId . '/colls/'.$collId;
        $client = new Client();

        $options = [
            'headers' => $headers,
        ];
        $response = $client->request('GET', $resourceUri, $options);
        $body = $response->getBody();
        $bodyContentString = $body->getContents();
        return json_decode($bodyContentString, true);
    }

    public function list($dbId){
        $headers = $this->core->getAuthHeaders('GET', 'colls', 'dbs/'.$dbId);
        $baseUri = $this->core->makeBaseUri();
        $resourceUri = $baseUri . '/dbs/' . $dbId . '/colls';
        $client = new Client();
        $options = [
            'headers' => $headers
        ];
        $response = $client->request('GET', $resourceUri, $options);
        $body = $response->getBody();
        $bodyContentString = $body->getContents();
        return json_decode($bodyContentString, true);
    }

    public function delete($dbId, $collId)
    {
        $headers = $this->core->getAuthHeaders('DELETE', 'colls', 'dbs/'.$dbId.'/colls/'.$collId);
        $baseUri = $this->core->makeBaseUri();
        $resourceUri = $baseUri . '/dbs/'.$dbId.'/colls/'.$collId;
        $client = new Client();
        $options = [
            'headers' => $headers
        ];
        $response = $client->request('DELETE', $resourceUri, $options);
        $status = $response->getStatusCode();
        return $status == '204';
    }

    public function replace($dbId, $collId, $indexingPolicy){
        $resourceLink = 'dbs/'.$dbId.'/colls/'.$collId;
        $headers = $this->core->getAuthHeaders('PUT', 'colls', $resourceLink);
        $baseUri = $this->core->makeBaseUri();
        $resourceUri = $baseUri . '/' . $resourceLink;
        $client = new Client();
        $body = [
            'id' => $collId,
            'indexingPolicy' => $indexingPolicy
        ];
        $options = [
            'headers' => $headers,
            'body' => json_encode($body)
        ];
        $response = $client->request('PUT', $resourceUri, $options);
        $bodyContentString = $response->getBody()->getContents();
        return json_decode($bodyContentString, true);
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
        $client = new Client();
        $options = [
            'headers' => $headers,
        ];
        $response = $client->request('GET', $resourceUri, $options);
        $bodyContentString = $response->getBody()->getContents();
        return json_decode($bodyContentString, true);
    }
}
