<?php
session_start();
require_once '../config/db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../loginSignup.php');
    exit;
}

// Helper: Export array to CSV
function export_csv($filename, $data, $headers) {
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="' . $filename . '"');
    $out = fopen('php://output', 'w');
    fputcsv($out, $headers);
    foreach ($data as $row) {
        fputcsv($out, $row);
    }
    fclose($out);
    exit;
}

function export_txt($filename, $data, $headers) {
    header('Content-Type: text/plain');
    header('Content-Disposition: attachment; filename="' . $filename . '"');
    echo implode("\t", $headers) . "\n";
    foreach ($data as $row) {
        echo implode("\t", $row) . "\n";
    }
    exit;
}

function export_json($filename, $data) {
    header('Content-Type: application/json');
    header('Content-Disposition: attachment; filename="' . $filename . '"');
    echo json_encode($data, JSON_PRETTY_PRINT);
    exit;
}

// Fetch data
$users = $pdo->query('SELECT id, username, email, role, created_at FROM users ORDER BY created_at DESC')->fetchAll(PDO::FETCH_ASSOC);
$products = $pdo->query('SELECT id, title, price, stock, status, created_at FROM products ORDER BY created_at DESC')->fetchAll(PDO::FETCH_ASSOC);
$orders = $pdo->query('SELECT id, user_id, total, status, created_at FROM orders ORDER BY created_at DESC')->fetchAll(PDO::FETCH_ASSOC);

// Handle export
if (isset($_GET['export'])) {
    $type = $_GET['export'];
    $format = $_GET['format'] ?? 'csv';
    if ($type === 'users') {
        if ($format === 'csv') export_csv('users_report.csv', $users, ['ID','Username','Email','Role','Created']);
        if ($format === 'txt') export_txt('users_report.txt', $users, ['ID','Username','Email','Role','Created']);
        if ($format === 'json') export_json('users_report.json', $users);
    } elseif ($type === 'products') {
        if ($format === 'csv') export_csv('products_report.csv', $products, ['ID','Title','Price','Stock','Status','Created']);
        if ($format === 'txt') export_txt('products_report.txt', $products, ['ID','Title','Price','Stock','Status','Created']);
        if ($format === 'json') export_json('products_report.json', $products);
    } elseif ($type === 'orders') {
        if ($format === 'csv') export_csv('orders_report.csv', $orders, ['ID','User ID','Total','Status','Created']);
        if ($format === 'txt') export_txt('orders_report.txt', $orders, ['ID','User ID','Total','Status','Created']);
        if ($format === 'json') export_json('orders_report.json', $orders);
    }
    // For Excel/PDF, you can add more export logic or use a library (e.g., PhpSpreadsheet, TCPDF)
}

// Handle export all
if (isset($_GET['export']) && $_GET['export'] === 'all') {
    $format = $_GET['format'] ?? 'csv';
    if ($format === 'csv' || $format === 'txt') {
        $filename = 'pulsebuy_export.' . $format;
        header('Content-Type: ' . ($format === 'csv' ? 'text/csv' : 'text/plain'));
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        $out = fopen('php://output', 'w');
        $sep = $format === 'csv' ? ',' : "\t";
        // Users
        fwrite($out, "USERS\n");
        fputcsv($out, ['ID','Username','Email','Role','Created'], $sep);
        foreach ($users as $row) fputcsv($out, $row, $sep);
        fwrite($out, "\nPRODUCTS\n");
        fputcsv($out, ['ID','Title','Price','Stock','Status','Created'], $sep);
        foreach ($products as $row) fputcsv($out, $row, $sep);
        fwrite($out, "\nORDERS\n");
        fputcsv($out, ['ID','User ID','Total','Status','Created'], $sep);
        foreach ($orders as $row) fputcsv($out, $row, $sep);
        fclose($out);
        exit;
    } elseif ($format === 'json') {
        $filename = 'pulsebuy_export.json';
        header('Content-Type: application/json');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        echo json_encode([
            'users' => $users,
            'products' => $products,
            'orders' => $orders
        ], JSON_PRETTY_PRINT);
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Reports - PulseBuy</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { background: #F5F7FA; font-family: 'Poppins', sans-serif; color: #22252A; margin: 0; }
        .container { max-width: 1100px; margin: 40px auto; background: #fff; border-radius: 12px; box-shadow: 0 2px 8px #0001; padding: 32px; }
        h1 { font-size: 2.2rem; font-weight: 700; color: #0056E0; margin-bottom: 24px; }
        .section { margin-bottom: 32px; }
        .export-btn { background: #0056E0; color: #fff; border: none; border-radius: 6px; padding: 8px 18px; font-weight: 600; cursor: pointer; margin-right: 10px; transition: background 0.2s; }
        .export-btn:hover { background: #003e99; }
        table { width: 100%; border-collapse: collapse; margin-top: 18px; }
        th, td { padding: 10px 8px; border-bottom: 1px solid #e5e9ef; text-align: left; }
        th { background: #f5f7fa; color: #0056E0; font-weight: 700; }
        tr:last-child td { border-bottom: none; }
    </style>
</head>
<body>
    <div class="container">
        <h1><i class="fas fa-chart-bar"></i> Admin Reports</h1>
        <div class="section">
            <h2>Download All Data</h2>
            <a href="?export=all&format=csv" class="export-btn"><i class="fas fa-file-csv"></i> CSV</a>
            <a href="?export=all&format=txt" class="export-btn"><i class="fas fa-file-alt"></i> TXT</a>
            <a href="?export=all&format=json" class="export-btn"><i class="fas fa-file-code"></i> JSON</a>
        </div>
        <div class="section">
            <h2>Users</h2>
            <a href="?export=users&format=csv" class="export-btn"><i class="fas fa-file-csv"></i> CSV</a>
            <a href="?export=users&format=txt" class="export-btn"><i class="fas fa-file-alt"></i> TXT</a>
            <a href="?export=users&format=json" class="export-btn"><i class="fas fa-file-code"></i> JSON</a>
            <table>
                <thead><tr><th>ID</th><th>Username</th><th>Email</th><th>Role</th><th>Created</th></tr></thead>
                <tbody>
                    <?php foreach ($users as $u): ?>
                    <tr>
                        <td><?= $u['id'] ?></td>
                        <td><?= htmlspecialchars($u['username']) ?></td>
                        <td><?= htmlspecialchars($u['email']) ?></td>
                        <td><?= htmlspecialchars($u['role']) ?></td>
                        <td><?= $u['created_at'] ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <div class="section">
            <h2>Products</h2>
            <a href="?export=products&format=csv" class="export-btn"><i class="fas fa-file-csv"></i> CSV</a>
            <a href="?export=products&format=txt" class="export-btn"><i class="fas fa-file-alt"></i> TXT</a>
            <a href="?export=products&format=json" class="export-btn"><i class="fas fa-file-code"></i> JSON</a>
            <table>
                <thead><tr><th>ID</th><th>Title</th><th>Price</th><th>Stock</th><th>Status</th><th>Created</th></tr></thead>
                <tbody>
                    <?php foreach ($products as $p): ?>
                    <tr>
                        <td><?= $p['id'] ?></td>
                        <td><?= htmlspecialchars($p['title']) ?></td>
                        <td>R<?= number_format($p['price'], 2) ?></td>
                        <td><?= $p['stock'] ?></td>
                        <td><?= htmlspecialchars($p['status']) ?></td>
                        <td><?= $p['created_at'] ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <div class="section">
            <h2>Orders</h2>
            <a href="?export=orders&format=csv" class="export-btn"><i class="fas fa-file-csv"></i> CSV</a>
            <a href="?export=orders&format=txt" class="export-btn"><i class="fas fa-file-alt"></i> TXT</a>
            <a href="?export=orders&format=json" class="export-btn"><i class="fas fa-file-code"></i> JSON</a>
            <table>
                <thead><tr><th>ID</th><th>User ID</th><th>Total</th><th>Status</th><th>Created</th></tr></thead>
                <tbody>
                    <?php foreach ($orders as $o): ?>
                    <tr>
                        <td><?= $o['id'] ?></td>
                        <td><?= $o['user_id'] ?></td>
                        <td>R<?= number_format($o['total'], 2) ?></td>
                        <td><?= htmlspecialchars($o['status']) ?></td>
                        <td><?= $o['created_at'] ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
