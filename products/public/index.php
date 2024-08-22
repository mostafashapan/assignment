<?php

require_once __DIR__ . '/../load-env.php';
require_once __DIR__ . '/../vendor/autoload.php';

use App\Controller\ProductController;

// Load environment variables
loadEnv(__DIR__ . '/../.env');

// Create a ProductController instance
$productController = new ProductController();

function sendResponse($statusCode, $message)
{
    header("HTTP/1.1 $statusCode");
    header('Content-Type: application/json');
    echo json_encode($message);
    exit;
}

function handleGetRequest($productController)
{
    $requestUri = $_SERVER['REQUEST_URI'];

    if ($requestUri === '/products') {
        $products = $productController->getAllProducts();
        sendResponse(200, $products);
    } elseif (preg_match('/^\/products\/([a-zA-Z0-9]+)$/', $requestUri, $matches)) {
        $sku = $matches[1];
        $product = $productController->getProduct($sku);
        if ($product) {
            sendResponse(200, $product);
        } else {
            sendResponse(404, ['error' => 'Product not found']);
        }
    } else {
        sendResponse(404, ['error' => 'Not Found']);
    }
}

function handlePostRequest($productController)
{
    $data = json_decode(file_get_contents('php://input'), true);

    if (json_last_error() !== JSON_ERROR_NONE) {
        sendResponse(400, ['error' => 'Invalid JSON format']);
    }

    try {
        $productController->saveProduct($data);
        sendResponse(200, ['status' => 'success']);
    } catch (Exception $e) {
        if (strpos($e->getMessage(), 'Duplicate entry') !== false) {
            sendResponse(400, ['error' => 'SKU already exists']);
        } else {
            sendResponse(500, ['error' => 'Server error: ' . htmlspecialchars($e->getMessage())]);
        }
    }
}

function handlePutRequest($productController)
{
    $requestUri = $_SERVER['REQUEST_URI'];
    if (preg_match('/^\/products\/([a-zA-Z0-9]+)$/', $requestUri, $matches)) {
        $sku = $matches[1];
        $data = json_decode(file_get_contents('php://input'), true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            sendResponse(400, ['error' => 'Invalid JSON format']);
        }

        try {
            $productController->updateProduct($sku, $data);
            sendResponse(200, ['status' => 'success']);
        } catch (Exception $e) {
            sendResponse(500, ['error' => 'Server error: ' . htmlspecialchars($e->getMessage())]);
        }
    } else {
        sendResponse(404, ['error' => 'Not Found']);
    }
}

function handleDeleteRequest($productController)
{
    $query = parse_url($_SERVER['REQUEST_URI'], PHP_URL_QUERY);
    parse_str($query, $queryParams);

    if (isset($queryParams['sku'])) {
        $sku = $queryParams['sku'];
        try {
            $productController->deleteProduct($sku);
            sendResponse(200, ['status' => 'success']);
        } catch (Exception $e) {
            sendResponse(500, ['error' => 'Internal Server Error: ' . htmlspecialchars($e->getMessage())]);
        }
    } else {
        sendResponse(400, ['error' => 'Bad Request: Missing SKU']);
    }
}

// Handle CORS preflight requests
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
    header('Access-Control-Allow-Headers: Content-Type');
    exit;
}

// Handle CORS for all other requests
header('Access-Control-Allow-Origin: *');

// Route requests based on HTTP method
switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        handleGetRequest($productController);
        break;
    case 'POST':
        handlePostRequest($productController);
        break;
    case 'PUT':
        handlePutRequest($productController);
        break;
    case 'DELETE':
        handleDeleteRequest($productController);
        break;
    default:
        sendResponse(405, ['error' => 'Method not allowed']);
}
