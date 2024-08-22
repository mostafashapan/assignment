<?php

namespace App\Model;

class Book extends Product
{
    private $weight;

    public function __construct($sku, $name, $price, $description, $weight)
    {
        parent::__construct($sku, $name, $price, $description);
        $this->weight = $weight;
    }

    public function getWeight()
    {
        return $this->weight;
    }

    public function getProductDetails(): array
    {
        return [
            'weight' => $this->weight,
        ];
    }
}
