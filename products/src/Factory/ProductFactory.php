<?php

namespace App\Factory;

use App\Model\Product;

class ProductFactory
{
    private static $factories = [
        'DVD' => DVDFactory::class,
        'Furniture' => FurnitureFactory::class,
        'Book' => BookFactory::class,
    ];

    public static function createProduct(array $data): Product
    {
        $type = $data['type'] ?? null;
        if (!isset(self::$factories[$type])) {
            throw new \Exception('Invalid product type');
        }

        $factoryClass = self::$factories[$type];
        return $factoryClass::createProduct($data);
    }
}
