<?php

namespace App\providers;

use App\util\BaseDataProvider;

class OrderDataProvider extends BaseDataProvider
{

    public function collection()
    {
        return 'orders';
    }
}