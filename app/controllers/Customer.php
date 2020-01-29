<?php

namespace App\controllers;

use App\providers\CustomerDataProvider;
use App\util\ModelUtil;
use MongoDB\BSON\ObjectId;

class Customer
{
    use ModelUtil;

    public function showCustomer($id)
    {
        $searchArray = ['_id' => $this->toObjectId($id)];
        $obj = new CustomerDataProvider();
        $result = $obj->findOne($searchArray);
        $result['_id'] = (string)$result['_id'];
        return $result;
    }

    public function showAllCustomer()
    {
        $obj = new CustomerDataProvider();
        $customers = $obj->find();
        $result = [];
        foreach ($customers as $customer) {
            $customer['_id'] = (string)$customer['_id'];
            $result[] = $customer;
        }
        return $result;
    }

    public function createCustomer($data)
    {
        $obj = new CustomerDataProvider();
        return $obj->insertOne($data);
    }

    public function updateCustomer($id, $data)
    {
        $searchArray = ['_id' => new ObjectId($id)];
        $updateArray = ['$set' => $data];
        $obj = new CustomerDataProvider();
        return $obj->updateOne($searchArray, $updateArray);
    }

    public function deleteUser($id)
    {
        $searchArray = ['_id' => new ObjectId($id)];
        $obj = new CustomerDataProvider();
        return $obj->deleteOne($searchArray);
    }
}