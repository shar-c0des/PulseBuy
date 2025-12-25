<?php
session_start();
require_once '../config/db.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: /login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id'];
    $total = $_POST['total'];

    try {
        $pdo->beginTransaction();
        // Create order
        $stmt = $pdo->prepare('INSERT INTO orders (user_id, total, status, created_at) VALUES (?, ?, ?, NOW())');
        $stmt->execute([$user_id, $total, 'completed']);
        $order_id = $pdo->lastInsertId();

        // Get cart items
        $cart_items = $pdo->prepare('SELECT cart.product_id, cart.quantity, products.price FROM cart JOIN products ON cart.product_id = products.id WHERE cart.user_id = ?');
        $cart_items->execute([$user_id]);
        $items = $cart_items->fetchAll();

        foreach ($items as $item) {
            // Add order item
            $stmt = $pdo->prepare('INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)');
            $stmt->execute([$order_id, $item['product_id'], $item['quantity'], $item['price']]);
            // Update product stock
            $stmt = $pdo->prepare('UPDATE products SET stock = stock - ? WHERE id = ? AND stock >= ?');
            $stmt->execute([$item['quantity'], $item['product_id'], $item['quantity']]);
        }

        // Create transaction record
        $stmt = $pdo->prepare('INSERT INTO transactions (order_id, amount, status, created_at) VALUES (?, ?, ?, NOW())');
        $stmt->execute([$order_id, $total, 'success']);

        // Empty cart
        $stmt = $pdo->prepare('DELETE FROM cart WHERE user_id = ?');
        $stmt->execute([$user_id]);

        $pdo->commit();
        header('Location: /order/confirmation.php?order_id=' . $order_id);
        exit;
    } catch (Exception $e) {
        $pdo->rollBack();
        echo "Payment failed: " . $e->getMessage();
    }
}