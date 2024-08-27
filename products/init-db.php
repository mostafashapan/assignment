<?php

require 'vendor/autoload.php'; // Ensure Composer autoload is used

use App\Database\Database;

try {
    $pdo = Database::getConnection();
    
    $sqlFile = '/var/www/html/products.sql';
    $sql = file_get_contents($sqlFile);

    if ($sql === false) {
        throw new Exception('Unable to read SQL file.');
    }

    // Prepare SQL commands
    $pdo->beginTransaction();
    $queries = explode(';', $sql);
    foreach ($queries as $query) {
        $query = trim($query);
        if (!empty($query)) {
            $pdo->exec($query);
        }
    }
    $pdo->commit();

    echo "Database initialized successfully.";
} catch (Exception $e) {
    if ($pdo->inTransaction()) {
        $pdo->rollBack();
    }
    echo "Error: " . $e->getMessage();
}
