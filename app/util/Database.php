<?php

namespace App\util;

use MongoDB;

class Database {

    private $dbName="shopping";

    public function setDbAndCollection($collection_name)
    {
        $client = new MongoDB\Client('mongodb://localhost:27017');
        $db = $client->selectDatabase($this->dbName);
        $options = ["typeMap" => ['root' => 'array', 'document' => 'array']];
        $colln = $db->selectCollection($collection_name,$options);
        return $colln;
    }
}