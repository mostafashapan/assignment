<?php

namespace App\Model;

class DVD extends Product
{
    private $size;

    public function __construct($sku, $name, $price, $description, $size)
    {
        parent::__construct($sku, $name, $price, $description);
        $this->size = $size;
    }

    public function getSize()
    {
        return $this->size;
    }

    public function getProductDetails(): array
    {
        return [
            'size' => $this->size,
        ];
    }
}
