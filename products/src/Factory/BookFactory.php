<?php

namespace App\Factory;

use App\Model\Book;
use App\Model\Product;

class BookFactory implements ProductFactoryInterface
{
    public static function createProduct(array $data): Product
    {
        return new Book(
            $data['sku'],
            $data['name'],
            (float) $data['price'],
            $data['description'],
            (float) $data['weight']
        );
    }
}
