<?php

namespace App\util;

use MongoDB\BSON\ObjectId;
use MongoDB\BSON\UTCDateTime;

trait   ModelUtil
{
    public function toObjectId($id) {
        if (is_array($id)) {
            $result = [];
            foreach ($id as $value) {
                $result[] = new ObjectId($value);
            }
            return $result;
        } else {
            return new ObjectId($id);
        }
    }

    public function getISODate(int $timestamp) {
        return new UTCDateTime($timestamp * 1000);
    }

    public function getTimeStamp(UTCDateTime $date) {
        return $date->toDateTime()->getTimestamp();
    }
}