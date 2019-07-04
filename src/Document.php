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
        $client = new Client();
        $options = [
            'headers' => $headers,
            'body' => json_encode($docs)
        ];
        $response = $client->request('POST', $resourceUri, $options);
        $body = $response->getBody();
        $bodyContentString = $body->getContents();
        return json_decode($bodyContentString, true);
    }

    public function get($dbId, $collId, $docId)
    {
        $resourceLink = 'dbs/'.$dbId.'/colls/'.$collId.'/docs/'.$docId;
        $headers = $this->core->getAuthHeaders('GET', 'docs', $resourceLink);
        $baseUri = $this->core->makeBaseUri();
        $client = new Client();
        $resourceUri = $baseUri . '/' . $resourceLink;
        $options = [
            'headers' => $headers
        ];
        $response = $client->request('GET', $resourceUri, $options);
        $body = $response->getBody();
        $bodyContentString = $body->getContents();
        return json_decode($bodyContentString, true);
    }

    public function list($dbId, $collId, $max = null)
    {
        $resourceLink = 'dbs/'.$dbId.'/colls/'.$collId;
        $headers = $this->core->getAuthHeaders('GET', 'docs', $resourceLink);
        if(is_null($max) == false){
            $headers['x-ms-max-item-count'] = $max;
        }
        $baseUri = $this->core->makeBaseUri();
        $client = new Client();
        $resourceUri = $baseUri . '/' . $resourceLink . '/docs';
        $options = [
            'headers' => $headers
        ];
        $response = $client->request('GET', $resourceUri, $options);
        $body = $response->getBody();
        $bodyContentString = $body->getContents();
        return json_decode($bodyContentString, true);
    }

    public function replace($dbId, $collId, $docId, $doc)
    {
        $resourceLink = 'dbs/'.$dbId.'/colls/'.$collId.'/docs/'.$docId;
        $headers = $this->core->getAuthHeaders('PUT', 'docs', $resourceLink);
        $baseUri = $this->core->makeBaseUri();
        $client = new Client();
        $resourceUri = $baseUri . '/' . $resourceLink;
        $options = [
            'headers' => $headers,
            'body' => json_encode($doc)
        ];
        $response = $client->request('PUT', $resourceUri, $options);
        $body = $response->getBody();
        $bodyContentString = $body->getContents();
        return json_decode($bodyContentString, true);
    }

    public function delete($dbId, $collId, $docId)
    {
        $resourceLink = 'dbs/'.$dbId.'/colls/'.$collId.'/docs/'.$docId;
        $headers = $this->core->getAuthHeaders('DELETE', 'docs', $resourceLink);
        $baseUri = $this->core->makeBaseUri();
        $client = new Client();
        $resourceUri = $baseUri . '/' . $resourceLink;
        $options = [
            'headers' => $headers,
        ];
        $response = $client->request('DELETE', $resourceUri, $options);
        $status = $response->getStatusCode();
        return $status == '204';
    }

    public function query($dbId, $collId, $query, $params)
    {
        $resourceLink = 'dbs/'.$dbId.'/colls/'.$collId;
        $headers = $this->core->getAuthHeaders('POST', 'docs', $resourceLink);
        $headers['x-ms-documentdb-isquery'] = 'True';
        $headers['Content-Type'] = 'application/query+json';
        $baseUri = $this->core->makeBaseUri();
        $client = new Client();
        $resourceUri = $baseUri . '/' . $resourceLink .'/docs';
        $body = [
            'query' => $query,
            'parameters' => $params
        ];
        $options = [
            'headers' => $headers,
            'body' => json_encode($body)
        ];

        $response = $client->request('POST', $resourceUri, $options);
        $bodyContentString = $response->getBody()->getContents();
        return json_decode($bodyContentString, true);
    }
}
