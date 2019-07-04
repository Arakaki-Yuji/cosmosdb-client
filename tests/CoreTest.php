<?php
use PHPUnit\Framework\TestCase;

use CosmosdbClient\Core;

class CoreTest extends TestCase
{
    public function setUp()
    {
        $this->masterKey = $_ENV['CC_COSMOSDB_ACCESS_KEY'];
        $this->accountName = $_ENV['CC_COSMOSDB_ACCOUNT_NAME'];
    }

    public function testConstructor()
    {
        $core = new Core($this->masterKey, $this->accountName);
        $this->assertInstanceOf('CosmosdbClient\Core', $core);
    }

    public function testGetAuthHeaders()
    {
        $core = new Core($this->masterKey, $this->accountName);
        $authArray = $core->getAuthHeaders('GET', 'dbs', '');

        $this->assertArrayHasKey('Content-Type', $authArray);
        $this->assertArrayHasKey('x-ms-date', $authArray);
        $this->assertArrayHasKey('x-ms-version', $authArray);
        $this->assertArrayHasKey('Authorization', $authArray);
    }
}
