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

$user_id = $_SESSION['user_id'];
$sql = "SELECT cart.id, products.title, products.price, cart.quantity 
        FROM cart 
        JOIN products ON cart.product_id = products.id 
        WHERE cart.user_id = $user_id";
$result = $pdo->query($sql);

$rows = $result->fetchAll(PDO::FETCH_ASSOC);
$total = 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Shopping Cart - PulseBuy</title>
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
        .cart-container {
            max-width: 900px;
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
            margin-bottom: 24px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 24px;
        }
        th, td {
            padding: 14px 10px;
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
        .remove-btn {
            background: #f44336;
            color: #fff;
            border: none;
            border-radius: 6px;
            padding: 8px 14px;
            font-size: 14px;
            cursor: pointer;
            transition: background 0.2s;
        }
        .remove-btn:hover {
            background: #c62828;
        }
        .cart-total {
            font-size: 1.2rem;
            font-weight: 600;
            color: #0056E0;
            text-align: right;
            padding-top: 10px;
        }
        .pay-btn {
            background: #0056E0;
            color: #fff;
            border: none;
            border-radius: 8px;
            padding: 14px 32px;
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.2s;
            box-shadow: 0 2px 8px rgba(0,86,224,0.10);
            display: flex;
            align-items: center;
            gap: 10px;
            margin-left: auto;
        }
        .pay-btn:hover {
            background: #003fa3;
        }
        .empty-cart {
            text-align: center;
            color: #888;
            font-size: 1.2rem;
            margin: 40px 0;
        }
    </style>
</head>
<body>
    <div class="cart-container">
        <h2><i class="fas fa-shopping-cart"></i> Shopping Cart</h2>
        <?php if (count($rows) > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Total</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($rows as $row): ?>
                        <tr>
                            <td><?= htmlspecialchars($row['title']) ?></td>
                            <td>R<?= number_format($row['price'], 2) ?></td>
                            <td><?= $row['quantity'] ?></td>
                            <td>R<?php $item_total = $row['price'] * $row['quantity']; echo number_format($item_total, 2); ?></td>
                            <td><a href="/cart/remove.php?id=<?= $row['id'] ?>" class="remove-btn"><i class="fa fa-trash"></i> Remove</a></td>
                        </tr>
                        <?php $total += $item_total; ?>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <div class="cart-total">Total: R<?= number_format($total, 2) ?></div>
            <form action="/payment/process.php" method="post" style="margin-top: 24px; text-align: right;">
                <input type="hidden" name="total" value="<?= $total ?>">
                <button type="submit" class="pay-btn"><i class="fas fa-credit-card"></i> Simulate Payment</button>
            </form>
        <?php else: ?>
            <div class="empty-cart">
                <i class="fa fa-shopping-cart" style="font-size:2.5rem;color:#E5E9EF;"></i><br>
                Your cart is empty.
            </div>
        <?php endif; ?>
    </div>
</body>
</html>