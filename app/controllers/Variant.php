<?php


namespace App\controllers;


use App\providers\ProductDataProvider;
use App\providers\VariantDataProvider;
use App\util\ModelUtil;
use MongoDB\BSON\ObjectId;

class Variant
{
    use ModelUtil;
    public function insertVariant($data)
    {
        $obj=new ProductDataProvider();
        $product_id=$data['product_id'];
        $id=['_id' => new ObjectId($product_id)];
        $result=$obj->findOne($id);
        $product_attributes=$result['attributes'];
        $variant_attributes=$data['attributes'];
        $product_attribute_count=count($product_attributes);
        $variant_attribute_count=count($variant_attributes);
        if($product_attribute_count!= $variant_attribute_count)
            return"attributes dosent match";
        else
        {
            for($i=0;$i<$product_attribute_count;$i++)
            {
                if (!isset($variant_attributes[$product_attributes[$i]]))
                {
                    return $variant_attributes[$i]." is not set";
                }
            }
            $obj = new VariantDataProvider();
            return $obj->insertOne($data);
        }

//        foreach ($product_attributes as $attribute) {
//            if (!isset($variant_attributes[$attribute]))
//            {
//                return $variant_attributes[$variant_attributes]." is not set";
//            }
//        }

    }

    public function showVariant($id)
    {
        $searchArray = ['_id' => new ObjectId($id)];
        $obj = new VariantDataProvider();
        $result = $obj->findOne($searchArray);
        $result['_id'] = (string)$result['_id'];
        return $result;

    }

    public function showAll()
    {
        $obj = new VariantDataProvider();
        $variants = $obj->find();
        $result = [];
        foreach ($variants as $variant) {
            $variant['_id'] = (string)$variant['_id'];
            $result[] = $variant;
        }
        return $result;
    }

    public function deleteVariant($id)
    {
        $searchArray = ['_id' => new ObjectId($id)];
        $obj = new VariantDataProvider();
        return $obj->deleteOne($searchArray);
    }

    public function updateVariant($id, $data)
    {

        $obj = new VariantDataProvider();
        $searchArray = ['_id' => new ObjectId($id)];
        $updateArray = ['$set' => $data];
        return $obj->updateOne($searchArray, $updateArray);

    }

    public function updateAll($updateArray)
    {
        $obj=new VariantDataProvider();


        $updateArray["offer_start_timestamp"]=$this->getISODate( $updateArray["offer_start_timestamp"]);
        $updateArray["offer_end_timestamp"]=$this->getISODate( $updateArray["offer_end_timestamp"]);
        $updateArray=['$set'=>$updateArray];
        return $obj->updateMany($searchArray = [],$updateArray);
    }

    public function bulkVariantsUpdate($searchArray, $updateArray)
    {
        $obj=new ProductDataProvider();
        $product_id=$updateArray['product_id'];
        $id=['_id' => new ObjectId($product_id)];
        $result=$obj->findOne($id);
        $product_attributes=$result['attributes'];
        $variant_attributes=$updateArray['attributes'];
        $product_attribute_count=count($product_attributes);
        $variant_attribute_count=count($variant_attributes);
        if($product_attribute_count!= $variant_attribute_count)
            return"attributes dosent match";
        else
        {
            foreach ($product_attributes as $attribute) {
            if (!isset($variant_attributes[$attribute]))
            {
                return $variant_attributes[$variant_attributes]." is not set";
            }
        }
            $obj = new VariantDataProvider();
            return $obj->prepareBulkUpdateMany($searchArray, $updateArray);
        }






    }
}