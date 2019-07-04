<?php
use PHPUnit\Framework\TestCase;

use CosmosdbClient\Core;
use CosmosdbClient\Database;

class DatabaseTest extends TestCase
{
    public function setUp()
    {
        $this->masterKey = $_ENV['CC_COSMOSDB_ACCESS_KEY'];
        $this->accountName = $_ENV['CC_COSMOSDB_ACCOUNT_NAME'];
        $this->core = new Core($this->masterKey, $this->accountName);
    }


    public function testConstructor()
    {
        $database = new Database($this->core);
        $this->assertInstanceOf('CosmosdbClient\Database', $database);
    }

    public function testRestApi()
    {
        $database = new Database($this->core);

        // create
        $id = 'test-cosmosdb-client';
        $result = $database->create($id);
        $this->assertArrayHasKey('id', $result);
        $this->assertArrayHasKey('_rid', $result);
        $this->assertArrayHasKey('_ts', $result);
        $this->assertArrayHasKey('_self', $result);
        $this->assertArrayHasKey('_etag', $result);
        $this->assertArrayHasKey('_colls', $result);
        $this->assertArrayHasKey('_users', $result);

        // list
        $result = $database->list();
        $this->assertArrayHasKey('_rid', $result);
        $this->assertArrayHasKey('_count', $result);
        $this->assertArrayHasKey('Databases', $result);

        // get
        $result = $database->get($id);
        $this->assertArrayHasKey('id', $result);
        $this->assertArrayHasKey('_rid', $result);
        $this->assertArrayHasKey('_ts', $result);
        $this->assertArrayHasKey('_self', $result);
        $this->assertArrayHasKey('_etag', $result);
        $this->assertArrayHasKey('_colls', $result);
        $this->assertArrayHasKey('_users', $result);

        // delete
        $result = $database->delete($id);
        $this->assertEquals(true, $result);
    }

}
