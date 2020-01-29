<?php

namespace App\controllers;

use App\providers\ProductDataProvider;
use App\providers\VariantDataProvider;
use MongoDB\BSON\ObjectId;

class Product {

    public function showProduct($id) {
        $searchArray = ['_id' => new ObjectId($id)];
        $obj = new ProductDataProvider();
        $result = $obj->findOne($searchArray);
        $result['_id'] = (string)$result['_id'];
        return $result;
    }

    public function showAllProducts() {
        $obj = new ProductDataProvider();
        $products = $obj->find();
        $result = [];
        foreach ($products as $product) {
            $product['_id'] = (string)$product['_id'];
            $result[] = $product;
        }
        return $result;
    }

    public function insertProduct($data) {
        $obj = new ProductDataProvider();
        return $obj->insertOne($data);
    }

    public function updateProduct($id, $data) {
        $searchArray = ['_id' => new ObjectId($id)];
        $updateArray = ['$set' => $data];
        $obj = new ProductDataProvider();
        $result = $obj->updateOne($searchArray, $updateArray);
        if ($data['status'] == "unavilable") {
            $searchArray = ['product_id' => $id];
            $updateArray = ['$set' => ['status' => 'unavilable']];
            $obj = new VariantDataProvider();
            $obj->updateMany($searchArray, $updateArray);
        }
        return $result;
    }

    public function deleteProduct($id) {
        $searchArray = ['_id' => new ObjectId($id)];
        $obj = new ProductDataProvider();
        return $obj->deleteOne($searchArray);
    }

    public function updateProductStatus($id, $data) {
        $searchArray = ['_id' => new ObjectId($id)];
        $updateArray = ['$set' => $data];
        $obj = new ProductDataProvider();
        return $obj->updateOne($searchArray, $updateArray);
    }

}