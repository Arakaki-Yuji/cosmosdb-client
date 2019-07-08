<?php
use PHPUnit\Framework\TestCase;

use CosmosdbClient\Core;
use CosmosdbClient\Database;
use CosmosdbClient\Collection;

class CollectionTest extends TestCase
{
    public function setUp()
    {
        $this->masterKey = $_ENV['CC_COSMOSDB_ACCESS_KEY'];
        $this->accountName = $_ENV['CC_COSMOSDB_ACCOUNT_NAME'];
        $this->core = new Core($this->masterKey, $this->accountName);

        $this->database = new Database($this->core);
        $this->dbId = 'test-cosmosdb-client-collection';
        try{
            $this->database->create($this->dbId);
        }catch(\Exception $e){
        }
    }

    public function tearDown()
    {
        // tearDown
        try{
            $this->database->delete($this->dbId);
        }catch(\Exception $e){
        }
    }

    public function testConstructor()
    {
        $collection = new Collection($this->core);
        $this->assertInstanceOf('CosmosdbClient\Collection', $collection);
    }

    public function testRestApi()
    {
        $collection = new Collection($this->core);

        // create
        $collId = 'test-collection';
        $result = $collection->create($this->dbId,
                                      $collId,
                                      null,
                                      ['paths' => ['/Name']]);
        $this->assertArrayHasKey('id', $result);
        $this->assertArrayHasKey('_rid', $result);
        $this->assertArrayHasKey('_ts', $result);
        $this->assertArrayHasKey('_self', $result);
        $this->assertArrayHasKey('_etag', $result);
        $this->assertArrayHasKey('_docs', $result);
        $this->assertArrayHasKey('_sprocs', $result);
        $this->assertArrayHasKey('_triggers', $result);
        $this->assertArrayHasKey('_udfs', $result);
        $this->assertArrayHasKey('_conflicts', $result);
        $this->assertArrayHasKey('indexingPolicy', $result);

        // get
        $result = $collection->get($this->dbId, $collId);
        $this->assertArrayHasKey('id', $result);
        $this->assertArrayHasKey('_rid', $result);
        $this->assertArrayHasKey('_ts', $result);
        $this->assertArrayHasKey('_self', $result);
        $this->assertArrayHasKey('_etag', $result);
        $this->assertArrayHasKey('_docs', $result);
        $this->assertArrayHasKey('_sprocs', $result);
        $this->assertArrayHasKey('_triggers', $result);
        $this->assertArrayHasKey('_udfs', $result);
        $this->assertArrayHasKey('_conflicts', $result);
        $this->assertArrayHasKey('indexingPolicy', $result);
        $this->assertEquals('consistent', $result['indexingPolicy']['indexingMode']);

        // list
        $result = $collection->list($this->dbId);
        $this->assertArrayHasKey('_rid', $result);
        $this->assertArrayHasKey('_count', $result);
        $this->assertArrayHasKey('DocumentCollections', $result);

        // replace
        $result = $collection->replace($this->dbId,
                                       $collId,
                                       ['indexingMode' => 'lazy'],
                                       ['paths' => ['/Name']]);
        $this->assertArrayHasKey('id', $result);
        $this->assertArrayHasKey('_rid', $result);
        $this->assertArrayHasKey('_ts', $result);
        $this->assertArrayHasKey('_self', $result);
        $this->assertArrayHasKey('_etag', $result);
        $this->assertArrayHasKey('_docs', $result);
        $this->assertArrayHasKey('_sprocs', $result);
        $this->assertArrayHasKey('_triggers', $result);
        $this->assertArrayHasKey('_udfs', $result);
        $this->assertArrayHasKey('_conflicts', $result);
        $this->assertArrayHasKey('indexingPolicy', $result);
        $this->assertEquals('lazy', $result['indexingPolicy']['indexingMode']);

        // delete
        $result = $collection->delete($this->dbId, $collId);
        $this->assertEquals(true, $result);
    }

    public function testGetPartiionkeyRanges()
    {
        $collId = 'test-collection-partitionkeyrange';
        $collection = new Collection($this->core);
        $collection->create($this->dbId,
                            $collId,
                            null,
                            ['paths' => ['/AccountNumber']]);

        // getpartitionkeyranges
        $result = $collection->getPartitionkeyRanges($this->dbId, $collId);
        $this->assertArrayHasKey('_rid', $result);
        $this->assertArrayHasKey('PartitionKeyRanges', $result);
        $this->assertArrayHasKey('_count', $result);
    }
}
