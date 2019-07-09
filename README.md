# cosmosdb-client

tiny cosmosdb client library for PHP.


# installation

Include arakaki-yuji/cosmosdb-client in your project, by adding it to your composer.json file.

``` json

{
    "require": {
        "arakaki-yuji/cosmosdb-client": "^0.0.5"
    }
}
```

# Usage

## Init

``` php

$client = new \CosmosdbClient\CosmosdbClient($cosmosdbSecretKey, $cosmosdbAccountName);

```

## Database

``` php
// create database
$client->database->create('database_id');

// list database
$client->database->list();

// get database
$client->database->get('database_id');

// delete database
$client->database->delete('database_id');
```

## Collection

``` php
// create collection
$indexingPolicy = ['indexingMode' => 'lazy'];
$partitionKey = ['paths' => ['/Name']];
$client->collection->create('database_id', 'collection_id', $indexingPolicy, $partitionKey);

// list collection
$client->collection->list('database_id');

// get collection
$client->collection->get('database_id', 'collection_id');

// replace/update collection
$client->collection->replace('database_id', 'collection_id', $indexingPolicy, $partitionKey);

// delete collection
$client->collection->delete('database_id', 'collection_id');

```

## Document

``` php
// create document
$doc = [
    'id' => 1,
    'name' => 'Yuji Arakaki',
    'email' => 'example@test.com'
];
$partitionKeyValue = $doc['name'];
$client->document->create('database_id', 'collection_id', $doc, $partitionKeyValue);

// list document
$client->document->list('database_id', 'collection_id');

// get document
$client->document->get('database_id', 'collection_id', $doc['id'], $partitionKeyValue);

// replace/update document
$client->document->replace('database_id', 'collection_id', $doc, $partitionKeyValue);

// query document
$query = "SELECT * FROM c WHERE c.name = @name";
$parameters = [['name' => '@name', 'value' => 'Yuji Arakaki']];
$client->document->query('database_id', 'collection_id', $query, $parameters);

// delete document
$client->document->delete('database_id', 'collection_id', $doc['id'], $partitionKeyValue);
```

