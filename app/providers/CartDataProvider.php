<?php

namespace App\providers;

use App\util\BaseDataProvider;

class CartDataProvider extends BaseDataProvider
{

    public function collection()
    {
        return 'cart';
    }
}