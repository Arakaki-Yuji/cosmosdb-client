<?php
use PHPUnit\Framework\TestCase;

use CosmosdbClient\CosmosdbClient;

class CosmosdbClientTest extends TestCase
{
    public function testConstructor()
    {
        $this->masterKey = $_ENV['CC_COSMOSDB_ACCESS_KEY'];
        $this->accountName = $_ENV['CC_COSMOSDB_ACCOUNT_NAME'];
        $client = new CosmosdbClient($this->masterKey, $this->accountName);
        $this->assertInstanceOf('CosmosdbClient\CosmosdbClient', $client);
        $this->assertInstanceOf('CosmosdbClient\Database', $client->database);
        $this->assertInstanceOf('CosmosdbClient\Collection', $client->collection);
        $this->assertInstanceOf('CosmosdbClient\Document', $client->document);
    }
}
