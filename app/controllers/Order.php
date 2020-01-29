<?php

namespace App\controllers;

use App\providers\CartDataProvider;
use App\providers\OrderDataProvider;
use App\providers\VariantDataProvider;
use Exception;
use MongoDB\BSON\ObjectId;

class Order {

    public function placeOrder($customerId) {
        $pipeline = [
            [
                '$match' => [
                    'customer_id' => $customerId
                ]
            ],
            [
                '$group' => [
                    '_id' => '$customer_id',
                    'total_price' => [
                        '$sum' => '$total'
                    ],
                    'products' => [
                        '$addToSet' => '$$ROOT'
                    ]
                ]
            ],
            [
                '$project' => [
                    'customer_id' => '$_id',
                    'products' => 1,
                    'total_price' => 1
                ]
            ],
            [
                '$project' => [

                    '_id' => 0,
                    'products._id' => 0,
                    'products.customer_id' => 0
                ]
            ]
        ];
        $obj = new CartDataProvider();
        $orders = $obj->aggregate($pipeline);
        $obj2 = new OrderDataProvider();
        $result = [];
        foreach ($orders as $order) {
            $result[] = $order;
        }

        if (empty($result[0])) {
            return false;
        }

        $check = $this->checkVariantStatus($result[0]);
        if (!$check) {
            throw new Exception('Some order items are not available');
        }

        return $this->updateStock($result[0]);
    }

    public function checkVariantStatus($order) {
        $variantIds = array();
        $variantMap = [];
        foreach ($order['products'] as $product) {
            $variantIds[] = new ObjectId($product['variant_id']);
            $variantMap[$product['variant_id']] = $product;
        }
        $searchArray = [
            '_id' => ['$in' => $variantIds]
        ];

        $variantsObj = new VariantDataProvider();
        $variants = $variantsObj->find($searchArray);

        foreach ($variants as $variant) {
            if ($variant['status'] != 'available') {
                return false;
            }

            $quantity = $variantMap[(string)$variant['_id']]['quantity'];
            if (($variant['stock'] - $quantity) < 0) {
                return false;
            }
        }
        return true;
    }

    public function updateStock($data) {
        $bulkOperations = [];
        $variantsObj = new VariantDataProvider();
        foreach ($data['products'] as $product) {
            $variantId = new ObjectId($product['variant_id']);
            $quantity = $product['quantity'];

            $searchArray = ['_id' => $variantId];
            $updateArray = [
                '$inc' => ['stock' => -($quantity)]
            ];

            $bulkOperations[] = $variantsObj->prepareBulkUpdateOne($searchArray, $updateArray);
        }
        return $variantsObj->bulkWrite($bulkOperations, true);
    }

    public function showOrder($customerId) {
        $searchArray = ['customer_id' => $customerId];
        $obj = new OrderDataProvider();
        return $obj->find($searchArray);
    }
}