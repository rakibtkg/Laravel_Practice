<?php

require __DIR__.'/../vendor/autoload.php';

$app = require_once __DIR__.'/../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Product;

echo "=== Product REST API Test ===\n\n";

// Create test products
echo "Creating test products...\n";
$products = [
    [
        'name' => 'Laptop',
        'description' => 'High-performance laptop for developers',
        'price' => 999.99,
        'stock' => 15
    ],
    [
        'name' => 'Wireless Mouse',
        'description' => 'Ergonomic wireless mouse',
        'price' => 29.99,
        'stock' => 50
    ],
    [
        'name' => 'Mechanical Keyboard',
        'description' => 'RGB mechanical keyboard',
        'price' => 149.99,
        'stock' => 25
    ]
];

foreach ($products as $productData) {
    $product = Product::create($productData);
    echo "✓ Created: {$product->name} (ID: {$product->id})\n";
}

echo "\nTotal products in database: " . Product::count() . "\n";
echo "\nTest products created successfully!\n";
echo "\n=== API Endpoints ===\n";
echo "GET    /api/products       - List all products\n";
echo "POST   /api/products       - Create new product\n";
echo "GET    /api/products/{id}  - Get product by ID\n";
echo "PUT    /api/products/{id}  - Update product\n";
echo "DELETE /api/products/{id}  - Delete product\n";
echo "\n=== Web Interface ===\n";
echo "Visit: http://localhost:8000/products\n";
