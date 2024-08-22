<?php

namespace App\Factory;

use App\Model\Furniture;
use App\Model\Product;

class FurnitureFactory implements ProductFactoryInterface
{
    public static function createProduct(array $data): Product
    {
        return new Furniture(
            $data['sku'],
            $data['name'],
            (float) $data['price'],
            $data['description'],
            (float) $data['height'],
            (float) $data['width'],
            (float) $data['length']
        );
    }
}
