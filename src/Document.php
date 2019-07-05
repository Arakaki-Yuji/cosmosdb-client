<?php
namespace CosmosdbClient;

use GuzzleHttp\Client;
use CosmosdbClient\Core;

class Document{
    private $core;

    public function __construct(Core $core)
    {
        $this->core = $core;
    }

    public function create($dbId, $collId, $docs)
    {
        $resourceLink = 'dbs/'.$dbId.'/colls/'.$collId;
        $headers = $this->core->getAuthHeaders('POST', 'docs', $resourceLink);
        $baseUri = $this->core->makeBaseUri();
        $resourceUri = $baseUri . '/' . $resourceLink . '/docs';
        $options = [
            'headers' => $headers,
            'body' => json_encode($docs)
        ];
        return $this->core->request('POST', $resourceUri, $options);
    }

    public function get($dbId, $collId, $docId)
    {
        $resourceLink = 'dbs/'.$dbId.'/colls/'.$collId.'/docs/'.$docId;
        $headers = $this->core->getAuthHeaders('GET', 'docs', $resourceLink);
        $baseUri = $this->core->makeBaseUri();
        $resourceUri = $baseUri . '/' . $resourceLink;
        $options = [
            'headers' => $headers
        ];
        return $this->core->request('GET', $resourceUri, $options);
    }

    public function list($dbId, $collId, $max = null)
    {
        $resourceLink = 'dbs/'.$dbId.'/colls/'.$collId;
        $headers = $this->core->getAuthHeaders('GET', 'docs', $resourceLink);
        if(is_null($max) == false){
            $headers['x-ms-max-item-count'] = $max;
        }
        $baseUri = $this->core->makeBaseUri();
        $resourceUri = $baseUri . '/' . $resourceLink . '/docs';
        $options = [
            'headers' => $headers
        ];
        return $this->core->request('GET', $resourceUri, $options);
    }

    public function replace($dbId, $collId, $docId, $doc)
    {
        $resourceLink = 'dbs/'.$dbId.'/colls/'.$collId.'/docs/'.$docId;
        $headers = $this->core->getAuthHeaders('PUT', 'docs', $resourceLink);
        $baseUri = $this->core->makeBaseUri();
        $resourceUri = $baseUri . '/' . $resourceLink;
        $options = [
            'headers' => $headers,
            'body' => json_encode($doc)
        ];
        return $this->core->request('PUT', $resourceUri, $options);
    }

    public function delete($dbId, $collId, $docId)
    {
        $resourceLink = 'dbs/'.$dbId.'/colls/'.$collId.'/docs/'.$docId;
        $headers = $this->core->getAuthHeaders('DELETE', 'docs', $resourceLink);
        $baseUri = $this->core->makeBaseUri();
        $resourceUri = $baseUri . '/' . $resourceLink;
        $options = [
            'headers' => $headers,
        ];
        $res = $this->core->request('DELETE', $resourceUri, $options);
        return is_null($res);
    }

    public function query($dbId, $collId, $query, $params)
    {
        $resourceLink = 'dbs/'.$dbId.'/colls/'.$collId;
        $headers = $this->core->getAuthHeaders('POST', 'docs', $resourceLink);
        $headers['x-ms-documentdb-isquery'] = 'True';
        $headers['Content-Type'] = 'application/query+json';
        $baseUri = $this->core->makeBaseUri();
        $resourceUri = $baseUri . '/' . $resourceLink .'/docs';
        $body = [
            'query' => $query,
            'parameters' => $params
        ];
        $options = [
            'headers' => $headers,
            'body' => json_encode($body)
        ];
        return $this->core->request('POST', $resourceUri, $options);
    }
}
