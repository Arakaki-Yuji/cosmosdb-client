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
        $options = [
            'headers' => $headers,
        ];
        return $this->core->request('GET', $resourceUri, $options);
    }

    public function get($dbId)
    {
        $headers = $this->core->getAuthHeaders('GET', 'dbs', 'dbs/' . $dbId);
        $baseUri = $this->core->makeBaseUri();
        $resourceUri = $baseUri . '/dbs/' . $dbId;
        $options = [
            'headers' => $headers
        ];
        return $this->core->request('GET', $resourceUri, $options);
    }

    public function create($dbId)
    {
        $headers = $this->core->getAuthHeaders('POST', 'dbs', '');
        $baseUri = $this->core->makeBaseUri();
        $resourceUri = $baseUri . '/dbs/';
        $options = [
            'headers' => $headers,
            'body' => json_encode(['id' => $dbId])
        ];
        return $this->core->request('POST', $resourceUri,$options);
    }

    public function delete($dbId)
    {
        $headers = $this->core->getAuthHeaders('DELETE', 'dbs', 'dbs/'.$dbId);
        $baseUri = $this->core->makeBaseUri();
        $resourceUri = $baseUri . '/dbs/'.$dbId;
        $options = [
            'headers' => $headers
        ];
        $res = $this->core->request('DELETE', $resourceUri,$options);
        return is_null($res);
    }

}
