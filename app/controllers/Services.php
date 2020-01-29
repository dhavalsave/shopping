<?php

namespace App\controllers;

use App\providers\ServiceDataProvider;
use MongoDB\BSON\ObjectId;

class Services {

    public function getService($id) {
        $obj = new ServiceDataProvider();
        $id = ['_id' => new ObjectId($id)];
        return $obj->findOne($id);
    }
}