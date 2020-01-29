<?php


namespace App\providers;


use App\util\BaseDataProvider;

class ServiceDataProvider extends BaseDataProvider
{

    public function collection()
    {
        return"services";
    }
}