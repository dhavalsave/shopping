<?php


namespace App\providers;


use App\util\BaseDataProvider;

class ProductDataProvider extends BaseDataProvider
{

    public function collection()
    {
        return 'products';
    }
}