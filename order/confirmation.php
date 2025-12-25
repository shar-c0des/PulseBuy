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

if (!isset($_GET['order_id'])) {
    header('Location: /');
    exit;
}

$order_id = (int)$_GET['order_id'];
$user_id = $_SESSION['user_id'];

// Verify the order belongs to the current user
$stmt = $pdo->prepare('SELECT * FROM orders WHERE id = ? AND user_id = ?');
$stmt->execute([$order_id, $user_id]);
$order = $stmt->fetch();
if (!$order) {
    header('Location: /');
    exit;
}

// Get order items
$stmt = $pdo->prepare('SELECT oi.*, p.title FROM order_items oi JOIN products p ON oi.product_id = p.id WHERE oi.order_id = ?');
$stmt->execute([$order_id]);
$items = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Order Confirmation - PulseBuy</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background: #F5F7FA;
            font-family: 'Poppins', sans-serif;
            color: #22252A;
            margin: 0;
            padding: 0;
        }
        .confirm-container {
            max-width: 700px;
            margin: 40px auto;
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 2px 12px rgba(0,86,224,0.08);
            padding: 32px 24px 24px 24px;
        }
        h2 {
            color: #0056E0;
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 18px;
        }
        h3 {
            color: #0056E0;
            font-size: 1.2rem;
            margin-top: 32px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 24px;
        }
        th, td {
            padding: 12px 8px;
            text-align: left;
        }
        th {
            background: #F5F7FA;
            color: #0056E0;
            font-weight: 600;
            border-bottom: 2px solid #E5E9EF;
        }
        tr {
            border-bottom: 1px solid #E5E9EF;
        }
        .total-row td {
            font-weight: 700;
            color: #0056E0;
        }
        .home-btn {
            background: #0056E0;
            color: #fff;
            border: none;
            border-radius: 8px;
            padding: 12px 28px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.2s;
            box-shadow: 0 2px 8px rgba(0,86,224,0.10);
            margin-top: 24px;
            display: inline-block;
        }
        .home-btn:hover {
            background: #003fa3;
        }
        .success-icon {
            color: #00C853;
            font-size: 2.5rem;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <div class="confirm-container">
        <div style="text-align:center;">
            <i class="fas fa-check-circle success-icon"></i>
            <h2>Order Confirmation</h2>
            <p>Your order (#<?= $order_id ?>) has been successfully placed!</p>
        </div>
        <h3>Order Details</h3>
        <table>
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($items as $item): ?>
                <tr>
                    <td><?= htmlspecialchars($item['title']) ?></td>
                    <td><?= $item['quantity'] ?></td>
                    <td>R<?= number_format($item['price'], 2) ?></td>
                    <td>R<?= number_format($item['price'] * $item['quantity'], 2) ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr class="total-row">
                    <td colspan="3">Total</td>
                    <td>R<?= number_format($order['total'], 2) ?></td>
                </tr>
            </tfoot>
        </table>
        <div style="text-align:center;">
            <p>Thank you for your purchase!</p>
            <a href="/" class="home-btn"><i class="fa fa-home"></i> Return to Home</a>
        </div>
    </div>
</body>
</html>