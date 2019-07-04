<?php
namespace CosmosdbClient;

use GuzzleHttp\Client;
use CosmosdbClient\Core;

class Database
{
    private $core;

    public function __construct(Core $core)
    {
        $this->core = $core;
    }

    public function list()
    {
        $headers = $this->core->getAuthHeaders('GET', 'dbs', '');
        $baseUri = $this->core->makeBaseUri();
        $resourceUri = $baseUri . '/dbs';
        $client = new Client();
        $options = [
            'headers' => $headers,
        ];
        $response = $client->request('GET', $resourceUri, $options);
        $body = $response->getBody();
        $bodyContentString = $body->getContents();
        return json_decode($bodyContentString, true);
    }

    public function get($dbId)
    {
        $headers = $this->core->getAuthHeaders('GET', 'dbs', 'dbs/' . $dbId);
        $baseUri = $this->core->makeBaseUri();
        $resourceUri = $baseUri . '/dbs/' . $dbId;
        $client = new Client();
        $options = [
            'headers' => $headers
        ];
        $response = $client->request('GET', $resourceUri, $options);
        $body = $response->getBody();
        $bodyContentString = $body->getContents();
        return json_decode($bodyContentString, true);
    }

    public function create($dbId)
    {
        $headers = $this->core->getAuthHeaders('POST', 'dbs', '');
        $baseUri = $this->core->makeBaseUri();
        $resourceUri = $baseUri . '/dbs/';
        $client = new Client();
        $options = [
            'headers' => $headers,
            'body' => json_encode(['id' => $dbId])
        ];
        $response = $client->request('POST', $resourceUri,$options);

        $body = $response->getBody();
        $bodyContentString = $body->getContents();
        return json_decode($bodyContentString, true);
    }

    public function delete($dbId)
    {
        $headers = $this->core->getAuthHeaders('DELETE', 'dbs', 'dbs/'.$dbId);
        $baseUri = $this->core->makeBaseUri();
        $resourceUri = $baseUri . '/dbs/'.$dbId;
        $client = new Client();
        $options = [
            'headers' => $headers
        ];
        $response = $client->request('DELETE', $resourceUri,$options);

        $status = $response->getStatusCode();
        return $status == '204';
    }

}
