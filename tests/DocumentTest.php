<?php
use PHPUnit\Framework\TestCase;

use CosmosdbClient\Core;
use CosmosdbClient\Database;
use CosmosdbClient\Collection;
use CosmosdbClient\Document;

class DocumentTest extends TestCase
{
    public function setUp()
    {
        $this->masterKey = $_ENV['CC_COSMOSDB_ACCESS_KEY'];
        $this->accountName = $_ENV['CC_COSMOSDB_ACCOUNT_NAME'];
        $this->core = new Core($this->masterKey, $this->accountName);

        $this->database = new Database($this->core);
        $this->collection = new Collection($this->core);
        $this->dbId = 'test-cosmosdb-client-docs';
        $this->collId = 'test-cosmosdb-client-docs-coll';
        try{
            $this->database->create($this->dbId);
            $this->collection->create($this->dbId, $this->collId);
        }catch(\Exception $e){
        }
    }

    public function tearDown()
    {
        try {
            $this->database->delete($this->dbId);
        }catch(\Exception $e){
        }
    }

    public function testRestApi()
    {
        $document = new Document($this->core);
        // create
        $docId = '1';
        $docs = [
            'id' => $docId,
            'name' => 'test',
            'email' => 'example@test.com'
        ];
        $result = $document->create($this->dbId, $this->collId, $docs);
        $this->assertArrayHasKey('id', $result);
        $this->assertArrayHasKey('name', $result);
        $this->assertArrayHasKey('email', $result);
        $this->assertArrayHasKey('_rid', $result);
        $this->assertArrayHasKey('_ts', $result);
        $this->assertArrayHasKey('_self', $result);
        $this->assertArrayHasKey('_etag', $result);

        // get
        $result = $document->get($this->dbId, $this->collId, $docId);
        $this->assertArrayHasKey('id', $result);
        $this->assertArrayHasKey('name', $result);
        $this->assertArrayHasKey('email', $result);
        $this->assertArrayHasKey('_rid', $result);
        $this->assertArrayHasKey('_ts', $result);
        $this->assertArrayHasKey('_self', $result);
        $this->assertArrayHasKey('_etag', $result);

        // list
        $result = $document->list($this->dbId, $this->collId);
        $this->assertArrayHasKey('_rid', $result);
        $this->assertArrayHasKey('_count', $result);
        $this->assertArrayHasKey('Documents', $result);
        $doc2 = [
            'id' => '2',
            'name' => 'test',
            'email' => 'example@test.com'
        ];
        $document->create($this->dbId, $this->collId,$doc2);
        $result = $document->list($this->dbId, $this->collId, 1);
        $this->assertEquals(1, count($result['Documents']));
        $result = $document->list($this->dbId, $this->collId);
        $this->assertEquals(2, count($result['Documents']));

        // replace
        $result = $document->replace($this->dbId, $this->collId, $docId,
                                     ['id' => $docId, 'name' => 'replacedName']);
        $this->assertArrayHasKey('id', $result);
        $this->assertArrayHasKey('name', $result);
        $this->assertEquals('replacedName', $result['name']);
        $this->assertArrayHasKey('_rid', $result);
        $this->assertArrayHasKey('_ts', $result);
        $this->assertArrayHasKey('_self', $result);
        $this->assertArrayHasKey('_etag', $result);

        // query
        $sql = "SELECT * FROM c WHERE c.id = @id";
        var_dump($sql);
        $result = $document->query($this->dbId, $this->collId,
                                   $sql,
                                   [['name'=> '@id', 'value' => '1']]);
        
        $this->assertArrayHasKey('_rid', $result);
        $this->assertArrayHasKey('_count', $result);
        $this->assertArrayHasKey('Documents', $result);
        $this->assertEquals(1, count($result['Documents']));
        $this->assertEquals('1', $result['Documents'][0]['id']);
        
        // delete
        $result = $document->delete($this->dbId, $this->collId, $docId);
        $this->assertEquals(true, $result);

    }
}
