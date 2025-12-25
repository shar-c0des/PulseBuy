<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
require_once '../config/db.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: /login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product_id = (int)$_POST['product_id'];
    $quantity = (int)$_POST['quantity'];
    $user_id = (int)$_SESSION['user_id'];

    // Check if product is in cart
    $stmt = $pdo->prepare('SELECT id, quantity FROM cart WHERE user_id = ? AND product_id = ?');
    $stmt->execute([$user_id, $product_id]);
    $row = $stmt->fetch();

    if ($row) {
        // Update quantity
        $stmt = $pdo->prepare('UPDATE cart SET quantity = quantity + ? WHERE id = ?');
        $stmt->execute([$quantity, $row['id']]);
    } else {
        // Insert new cart item
        $stmt = $pdo->prepare('INSERT INTO cart (user_id, product_id, quantity) VALUES (?, ?, ?)');
        $stmt->execute([$user_id, $product_id, $quantity]);
    }
    // Redirect back to the referring page (stay on products or product view)
    $redirect = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '/products.php';
    header('Location: ' . $redirect);
    exit;
}