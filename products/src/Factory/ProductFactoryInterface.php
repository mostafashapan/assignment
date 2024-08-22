<?php

namespace App\Factory;

use App\Model\Product;

interface ProductFactoryInterface
{
    public static function createProduct(array $data): Product;
}
