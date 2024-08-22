<?php

namespace App\Controller;

use App\Database\Database;
use PDO;

class ProductController
{
    private $pdo;

    public function __construct()
    {
        // Initialize PDO instance
        $this->pdo = Database::getConnection();
    }
    public function saveProduct($data)
    {
        try {
            $stmt = $this->pdo->prepare("
                INSERT INTO products (sku, name, price, type, size, height, width, length, weight, description)
                VALUES (:sku, :name, :price, :type, :size, :height, :width, :length, :weight, :description)
            ");
            $stmt->execute([
                ':sku' => $data['sku'],
                ':name' => $data['name'],
                ':price' => $data['price'],
                ':type' => $data['type'],
                ':size' => $data['size'] ?? null,
                ':height' => $data['height'] ?? null,
                ':width' => $data['width'] ?? null,
                ':length' => $data['length'] ?? null,
                ':weight' => $data['weight'] ?? null,
                ':description' => $data['description'] ?? null,
            ]);
        } catch (PDOException $e) {
            // Check for duplicate entry error code
            if ($e->getCode() === '23000') {
                throw new Exception('Duplicate SKU detected');
            }
            throw new Exception('Database error: ' . $e->getMessage());
        }
    }
    public function getAllProducts()
    {
        $stmt = $this->pdo->prepare('SELECT * FROM products');
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // New method to get a specific product by SKU
    public function getProduct($sku)
    {
        $stmt = $this->pdo->prepare('SELECT * FROM products WHERE sku = :sku');
        $stmt->execute(['sku' => $sku]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function updateProduct($sku, $data)
    {
        $stmt = $this->pdo->prepare('UPDATE products SET name = :name, price = :price WHERE sku = :sku');
        $stmt->execute([
            'sku' => $sku,
            'name' => $data['name'],
            'price' => $data['price']
        ]);
    }

    public function deleteProduct($sku)
    {
        $stmt = $this->pdo->prepare('DELETE FROM products WHERE sku = :sku');
        $stmt->execute(['sku' => $sku]);
    }
}
