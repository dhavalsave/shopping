<?php

namespace App\providers;

use App\util\BaseDataProvider;

class CustomerDataProvider extends BaseDataProvider
{
    public function collection()
    {
        return 'customers';
    }
}