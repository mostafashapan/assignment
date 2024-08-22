<?php

namespace App\Factory;

use App\Model\DVD;
use App\Model\Product;

class DVDFactory implements ProductFactoryInterface
{
    public static function createProduct(array $data): Product
    {
        return new DVD(
            $data['sku'],
            $data['name'],
            (float) $data['price'],
            $data['description'],
            (float) $data['size']
        );
    }
}
