<?php

namespace App\providers;

use App\util\BaseDataProvider;

class VariantDataProvider extends BaseDataProvider
{

    public function collection()
    {
      return'variants';
    }
}