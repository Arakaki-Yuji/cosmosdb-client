<?php
namespace CosmosdbClient;
use CosmosdbClient\Core;
use CosmosdbClient\Database;
use CosmosdbClient\Collection;
use CosmosdbClient\Document;

class CosmosdbClient
{
    private $database;
    private $collection;
    private $document;

    public function __construct(string $masterkey,
                                string $account)
    {
        $core = new Core($masterkey, $account);
        $this->database = new Database($core);
        $this->collection = new Collection($core);
        $this->document = new Document($core);
    }

    public function __get($name)
    {
        switch($name){
        case 'database':
            return $this->database;
            break;
        case 'collection':
            return $this->collection;
            break;
        case 'document':
            return $this->document;
            break;
        }

        $trace = debug_backtrace();
        trigger_error(
            'Undefined property via __get(): ' . $name .
            ' in ' . $trace[0]['file'] .
            ' on line ' . $trace[0]['line'],
            E_USER_NOTICE);
        return null;
    }
}
