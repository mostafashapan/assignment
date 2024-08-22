<?php

namespace App\Model;

abstract class Product
{
    protected $sku;
    protected $name;
    protected $price;
    protected $description;

    public function __construct($sku, $name, $price, $description)
    {
        $this->sku = $sku;
        $this->name = $name;
        $this->price = $price;
        $this->description = $description;
    }

    public function getSku()
    {
        return $this->sku;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getPrice()
    {
        return $this->price;
    }

    public function getDescription()
    {
        return $this->description;
    }

    abstract public function getProductDetails(): array;
}
