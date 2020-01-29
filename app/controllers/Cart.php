<?php

namespace App\controllers;

use App\providers\CartDataProvider;
use App\providers\ServiceDataProvider;
use App\util\ModelUtil;
use MongoDB\BSON\ObjectId;

class Cart
{
    use ModelUtil;

    public function checkOffertime($startTime, $endTimme)
    {
        $currentTimeIso = time();
        $currentTimeIso = $this->getISODate($currentTimeIso);
        //dd($startTime,$endTimme,$currentTimeIso);
        if ($currentTimeIso >= $startTime && $currentTimeIso <= $endTimme) {
            return true;
        } else {
            return false;
        }
    }

    public function addToCart($data)
    {
        $customerObj = new Customer();
        $customer = $customerObj->showCustomer($data['customer_id']);

        $variantObj = new Variant();
        $variant = $variantObj->showVariant($data['variant_id']);
        $inOfferPeriod = $this->checkOffertime($variant['offer_start_timestamp'], $variant['offer_end_timestamp']);
        //  dd($inOfferPeriod,$variant,$data,$variant['offer_start_timestamp'],$variant['offer_end_timestamp']);
        //exit;
        if ($customer['pincode'] != $variant['pincode']) {
            throw new \Exception('Invalid location');
        }

        if ($variant['status'] != 'avilable') {
            throw new \Exception('Variant not available');
        }
        // dd($variant);
        if ($inOfferPeriod == true) {
            $variant['price'] = $variant['offer_price'];

            // dd( $variant['price'],$variant['offer_price']);
        }
        $serviceData = $this->getServiceData($data['quantity'], $data['services']);
        // dd($serviceData);

        $quantityPrice = ($variant['price'] * $data['quantity']) + $serviceData['price'];
        $cartData = [
            'customer_id' => $data['customer_id'],
            'variant_id' => $data['variant_id'],
            'product_id' => $variant['product_id'],
            'quantity' => $data['quantity'],
            'unit_price' => $variant['price'],
            'total_price' => $quantityPrice,
            'services' => $serviceData['services']
        ];
        //dd($cartData);

        $cartObj = new CartDataProvider();
        $result = $cartObj->insertOne($cartData);
        dd($result);
        return $result;
    }

    public function getServiceData($quantity, $serviceIds)
    {
        $result = [];
        $servicePrice = 0;
        $serviceObj = new ServiceDataProvider();

        foreach ($serviceIds as $serviceId) {
            $searchArray = ['_id' => $this->toObjectId($serviceId)];
            $serviceData = $serviceObj->findOne($searchArray);
            //dd($serviceData);
            if ($serviceData['per_quantity']) {
                $totalPrice = $serviceData['price'] * $quantity;
            } else {
                $totalPrice = $serviceData['price'];
            }
            $servicePrice += $totalPrice;

            $item = [
                'id' => $serviceId,
                'unit_price' => $serviceData['price'],
                'total_price' => $totalPrice
            ];

            $result[] = $item;
        }

        return [
            'services' => $result,
            'price' => $servicePrice
        ];
    }

    public function updateCart($id, $data)
    {
        $customerObj = new Customer();
        $customer = $customerObj->showCustomer($data['customer_id']);

        $variantObj = new Variant();
        $variant = $variantObj->showVariant($data['variant_id']);

        if ($customer['pincode'] != $variant['pincode']) {
            throw new \Exception('Invalid location');
        }

        if ($variant['status'] != 'available') {
            throw new \Exception('Variant not available');
        }

        if ($data['quantity'] == 0) {
            return $this->removeFromCart($id);
        }

        $quantityPrice = $variant['price'] * $data['quantity'];
        $cartData = [
            'quantity' => $data['quantity'],
            'unit_price' => $variant['price'],
            'total_price' => $quantityPrice
        ];

        $obj = new CartDataProvider();
        $searchArray = ['_id' => new ObjectId($id)];
        $updateArray = ['$set' => $cartData];
        return $obj->updateOne($searchArray, $updateArray);
    }

    public function removeFromCart($id)
    {
        $obj = new CartDataProvider();
        $searchArray = ['_id' => new ObjectId($id)];
        return $obj->deleteOne($searchArray);
    }

    public function showCart($customerId)
    {
        $searchArray = ['customer_id' => $customerId];
        $obj = new CartDataProvider();
        return $obj->find($searchArray);
    }

}