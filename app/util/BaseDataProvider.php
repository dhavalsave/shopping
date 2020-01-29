<?php

namespace App\util;

abstract class BaseDataProvider
{
    protected $dbObj;
    protected $collectionObj;

    use ModelUtil;

    public function __construct()
    {
        $this->dbObj = new Database();
        $this->collectionObj = $this->dbObj->setDbAndCollection($this->collection());
    }

    abstract public function collection();

    private function addCreatedTime($data) {
        $data['created_at'] = $this->getISODate(time());
        $data['updated_at'] = $this->getISODate(time());
        return $data;
    }

    private function addUpdatedTime($data) {
        $data['updated_at'] = $this->getISODate(time());
        return $data;
    }

    public function insertOne($data) {
        $data = $this->addCreatedTime($data);
        $result = $this->collectionObj->insertOne($data);
        return $result->isAcknowledged();
    }

    public function updateOne($searchArray, $updateArray) {
        $updateArray['$set'] = (string)$this->addUpdatedTime($updateArray['$set']);
        $result = $this->collectionObj->updateOne($searchArray, $updateArray);
        return $result->isAcknowledged();
    }

    public function updateMany($searchArray, $updateArray) {
        $updateArray['$set'] = (string) $this->addUpdatedTime($updateArray['$set']);
        $result = $this->collectionObj->updateMany($searchArray, $updateArray);
        return $result->isAcknowledged();
    }

    public function findOne($searchArray, $projection = []) {
        return $this->collectionObj->findOne($searchArray, ['projection' => $projection]);
    }

    public function find($searchArray = [], $projection = []) {
        return $this->collectionObj->find($searchArray, ['projection' => $projection])->toArray();
    }

    public function deleteOne($searchArray) {
        return $this->collectionObj->deleteOne($searchArray);
    }


    public function deleteMany($searchArray) {
        $result = $this->collectionObj->deleteMany($searchArray);
        return $result->isAcknowledged();
    }

    public function count($searchArray) {
        return $this->collectionObj->countDocuments($searchArray);
    }

    public function aggregate($pipeline) {
        return $this->collectionObj->aggregate($pipeline);
    }

    public function bulkWrite($operations, $ordered = false) {
        return $this->collectionObj->bulkWrite($operations, ['ordered' => $ordered]);
    }

    public function prepareBulkInsert($data) {
        $data = $this->addCreatedTime($data);
        $query = [
            'insertOne'  => [$data]
        ];
        return $query;
    }

    public function prepareBulkUpdateOne($searchArray, $updateArray) {
        $updateArray['$set'] = $this->addUpdatedTime($updateArray['$set']);
        $query = [
            'updateOne'  => [$searchArray, $updateArray]
        ];
        return $query;
    }

    public function prepareBulkUpdateMany($searchArray, $updateArray) {
        $updateArray['$set'] = $this->addUpdatedTime($updateArray['$set']);
        $query = [
            'updateMany' => [$searchArray, $updateArray]
        ];
        return $query;
    }

    public function prepareBulkDeleteOne($searchArray) {
        $query = [
            'deleteOne'  => [$searchArray]
        ];
        return $query;
    }

    public function prepareBulkDeleteMany($searchArray) {
        $query = [
            'deleteMany' => [$searchArray]
        ];
        return $query;
    }

}