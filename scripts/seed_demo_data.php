<?php
// scripts/seed_demo_data.php
// Run this script from the command line: php scripts/seed_demo_data.php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../config/db.php';

// Seller data
$sellers = [
    [
        'username' => 'shopalpha',
        'email' => 'alpha@example.com',
        'phone' => '0711111111',
        'password' => 'Password1!',
    ],
    [
        'username' => 'shopbravo',
        'email' => 'bravo@example.com',
        'phone' => '0722222222',
        'password' => 'Password1!',
    ],
    [
        'username' => 'shopcharlie',
        'email' => 'charlie@example.com',
        'phone' => '0733333333',
        'password' => 'Password1!',
    ],
    [
        'username' => 'shopdelta',
        'email' => 'delta@example.com',
        'phone' => '0744444444',
        'password' => 'Password1!',
    ],
    [
        'username' => 'shopecho',
        'email' => 'echo@example.com',
        'phone' => '0755555555',
        'password' => 'Password1!',
    ],
];

// Insert default categories if none exist
$default_categories = [
    'Electronics',
    'Fashion',
    'Home & Garden',
    'Beauty',
    'Sports'
];
$existing = $pdo->query('SELECT COUNT(*) as cnt FROM categories')->fetch();
if ($existing['cnt'] == 0) {
    $stmt = $pdo->prepare('INSERT INTO categories (name) VALUES (?)');
    foreach ($default_categories as $cat) {
        $stmt->execute([$cat]);
    }
    echo "Inserted default categories.\n";
}

// Fetch categories
$categories = $pdo->query('SELECT id, name FROM categories')->fetchAll(PDO::FETCH_ASSOC);
if (count($categories) < 1) {
    exit("No categories found. Please add categories first.\n");
}

// Insert sellers (skip if username or email exists)
$seller_ids = [];
foreach ($sellers as $seller) {
    $stmt = $pdo->prepare('SELECT id FROM users WHERE username = ? OR email = ? LIMIT 1');
    $stmt->execute([$seller['username'], $seller['email']]);
    $existing = $stmt->fetch();
    if ($existing) {
        $seller_ids[] = $existing['id'];
        continue;
    }
    $stmt = $pdo->prepare('INSERT INTO users (username, email, password_hash, phone, role, created_at) VALUES (?, ?, ?, ?, ?, NOW())');
    $stmt->execute([
        $seller['username'],
        $seller['email'],
        password_hash($seller['password'], PASSWORD_DEFAULT),
        $seller['phone'],
        'seller',
    ]);
    $seller_ids[] = $pdo->lastInsertId();
}

// Product templates
$product_templates = [
    [
        'title' => 'Wireless Headphones',
        'description' => 'High-quality wireless headphones with noise cancellation.',
        'price' => 899.99,
        'image_path' => 'src/uploads/products/prod_6861d09fced4d9.51757470.png',
    ],
    [
        'title' => 'Smart Fitness Watch',
        'description' => 'Track your fitness and health with this smart watch.',
        'price' => 1299.00,
        'image_path' => 'src/uploads/products/prod_6861d2261408a9.00745516.png',
    ],
    [
        'title' => 'Bluetooth Speaker',
        'description' => 'Portable Bluetooth speaker with deep bass.',
        'price' => 499.50,
        'image_path' => 'src/uploads/products/prod_6861d2e98ed1a0.12224255.png',
    ],
    [
        'title' => 'Gaming Mouse',
        'description' => 'Ergonomic gaming mouse with customizable buttons.',
        'price' => 399.99,
        'image_path' => 'src/uploads/products/prod_6861d66c3df864.31133486.png',
    ],
    [
        'title' => 'USB-C Charger',
        'description' => 'Fast-charging USB-C wall charger for all devices.',
        'price' => 299.00,
        'image_path' => 'src/uploads/products/prod_6861ea955643c4.75984938.png',
    ],
];

// Insert products for each seller (skip if product with same title and seller exists)
foreach ($seller_ids as $i => $seller_id) {
    for ($j = 0; $j < 5; $j++) {
        $template = $product_templates[$j];
        $category = $categories[($i + $j) % count($categories)];
        $stmt = $pdo->prepare('SELECT id FROM products WHERE user_id = ? AND title = ? LIMIT 1');
        $stmt->execute([$seller_id, $template['title']]);
        if ($stmt->fetch()) continue;
        $rand_stock = rand(10, 50);
        $stmt = $pdo->prepare('INSERT INTO products (user_id, title, description, price, category_id, status, image_path, created_at, updated_at, stock) VALUES (?, ?, ?, ?, ?, ?, ?, NOW(), NOW(), ?)');
        $stmt->execute([
            $seller_id,
            $template['title'],
            $template['description'],
            $template['price'],
            $category['id'],
            'active',
            $template['image_path'],
            $rand_stock,
        ]);
    }
}

echo "Seeded 5 sellers and 25 products successfully.\n"; 