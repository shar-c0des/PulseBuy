<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: loginSignup.php');
    exit;
}
require_once './config/db.php';

// Handle user deletion
if (isset($_POST['delete_user_id'])) {
    $delete_id = (int)$_POST['delete_user_id'];
    if ($delete_id !== $_SESSION['user_id']) { // Prevent self-delete
        // Get all order IDs for this user
        $orderIdsStmt = $pdo->prepare('SELECT id FROM orders WHERE user_id = ?');
        $orderIdsStmt->execute([$delete_id]);
        $orderIds = $orderIdsStmt->fetchAll(PDO::FETCH_COLUMN);
        if (!empty($orderIds)) {
            $in = str_repeat('?,', count($orderIds) - 1) . '?';
            // Delete all transactions for these orders
            $pdo->prepare("DELETE FROM transactions WHERE order_id IN ($in)")->execute($orderIds);
            // Delete all order_items for these orders
            $pdo->prepare("DELETE FROM order_items WHERE order_id IN ($in)")->execute($orderIds);
        }
        // Delete all orders for this user
        $pdo->prepare('DELETE FROM orders WHERE user_id = ?')->execute([$delete_id]);
        // Delete all order_items for this user's products
        $productIdsStmt = $pdo->prepare('SELECT id FROM products WHERE user_id = ?');
        $productIdsStmt->execute([$delete_id]);
        $productIds = $productIdsStmt->fetchAll(PDO::FETCH_COLUMN);
        if (!empty($productIds)) {
            $in = str_repeat('?,', count($productIds) - 1) . '?';
            $pdo->prepare("DELETE FROM order_items WHERE product_id IN ($in)")->execute($productIds);
        }
        // Delete all products for this user
        $pdo->prepare('DELETE FROM products WHERE user_id = ?')->execute([$delete_id]);
        // Now delete the user
        $stmt = $pdo->prepare('DELETE FROM users WHERE id = ?');
        $stmt->execute([$delete_id]);
        $msg = 'User and all related orders, order items, transactions, and products deleted.';
    }
}

// Handle user add/edit
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save_user'])) {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $role = $_POST['role'];
    $password = $_POST['password'];
    $user_id = isset($_POST['user_id']) ? (int)$_POST['user_id'] : 0;
    if ($user_id) {
        // Update
        $fields = ['username' => $username, 'email' => $email, 'role' => $role];
        if ($password) $fields['password_hash'] = password_hash($password, PASSWORD_DEFAULT);
        $set = [];
        $params = [];
        foreach ($fields as $k => $v) { $set[] = "$k = ?"; $params[] = $v; }
        $params[] = $user_id;
        $stmt = $pdo->prepare('UPDATE users SET '.implode(',', $set).' WHERE id = ?');
        $stmt->execute($params);
        $msg = 'User updated.';
    } else {
        // Add
        $stmt = $pdo->prepare('INSERT INTO users (username, email, password_hash, role, created_at) VALUES (?, ?, ?, ?, NOW())');
        $stmt->execute([$username, $email, password_hash($password, PASSWORD_DEFAULT), $role]);
        $msg = 'User added.';
    }
}

// Fetch all users
$users = $pdo->query('SELECT * FROM users ORDER BY created_at DESC')->fetchAll();
$stats = $pdo->query('SELECT role, COUNT(*) as total FROM users GROUP BY role')->fetchAll(PDO::FETCH_KEY_PAIR);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard - PulseBuy</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { background: #F5F7FA; font-family: 'Poppins', sans-serif; color: #22252A; margin: 0; }
        .container { max-width: 1100px; margin: 40px auto; background: #fff; border-radius: 12px; box-shadow: 0 2px 8px #0001; padding: 32px; }
        h1 { font-size: 2.2rem; font-weight: 700; color: #0056E0; margin-bottom: 24px; }
        .stats { display: flex; gap: 32px; margin-bottom: 32px; }
        .stat-card { background: #f8f9fa; border-radius: 10px; padding: 18px 32px; font-size: 1.1rem; font-weight: 600; color: #0056E0; box-shadow: 0 1px 4px #0001; }
        .user-table { width: 100%; border-collapse: collapse; margin-bottom: 32px; }
        .user-table th, .user-table td { padding: 12px 10px; border-bottom: 1px solid #e5e9ef; text-align: left; }
        .user-table th { background: #f5f7fa; color: #0056E0; font-weight: 700; }
        .user-table tr:last-child td { border-bottom: none; }
        .actions { display: flex; gap: 10px; }
        .btn { padding: 7px 18px; border: none; border-radius: 6px; font-weight: 600; cursor: pointer; transition: background 0.2s; }
        .btn-edit { background: #1A75FF; color: #fff; }
        .btn-delete { background: #F53F3F; color: #fff; }
        .btn-add { background: #00C853; color: #fff; margin-bottom: 18px; }
        .btn:disabled { background: #ccc; cursor: not-allowed; }
        .form-popup { background: #fff; border-radius: 10px; box-shadow: 0 2px 12px #0002; padding: 28px; position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); z-index: 1000; min-width: 340px; display: none; }
        .form-popup.active { display: block; }
        .form-popup h2 { margin-top: 0; color: #0056E0; }
        .form-group { margin-bottom: 18px; }
        .form-group label { display: block; font-weight: 600; margin-bottom: 6px; }
        .form-group input, .form-group select { width: 100%; padding: 8px 10px; border-radius: 5px; border: 1px solid #ddd; font-size: 1rem; }
        .form-actions { display: flex; gap: 12px; justify-content: flex-end; }
        .overlay { position: fixed; top: 0; left: 0; width: 100vw; height: 100vh; background: #0005; z-index: 999; display: none; }
        .overlay.active { display: block; }
        .msg { background: #e3fcec; color: #007e33; padding: 10px 18px; border-radius: 6px; margin-bottom: 18px; font-weight: 600; }
    </style>
</head>
<body>
    <div class="container">
        <h1><i class="fas fa-user-shield"></i> Admin Dashboard</h1>
        <a href="reports/generate.php" class="btn" style="background:#0056E0;color:#fff;margin-bottom:18px;display:inline-block;"><i class="fas fa-chart-bar"></i> Generate Reports</a>
        <?php if (!empty($msg)): ?><div class="msg"><?= htmlspecialchars($msg) ?></div><?php endif; ?>
        <div class="stats">
            <div class="stat-card">Admins: <?= $stats['admin'] ?? 0 ?></div>
            <div class="stat-card">Sellers: <?= $stats['seller'] ?? 0 ?></div>
            <div class="stat-card">Buyers: <?= $stats['buyer'] ?? 0 ?></div>
        </div>
        <button class="btn btn-add" onclick="openUserForm()"><i class="fas fa-user-plus"></i> Add User</button>
        <table class="user-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Created</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user): ?>
                <tr>
                    <td><?= $user['id'] ?></td>
                    <td><?= htmlspecialchars($user['username']) ?></td>
                    <td><?= htmlspecialchars($user['email']) ?></td>
                    <td><?= htmlspecialchars($user['role']) ?></td>
                    <td><?= date('Y-m-d', strtotime($user['created_at'])) ?></td>
                    <td class="actions">
                        <button class="btn btn-edit" onclick="openUserForm(<?= htmlspecialchars(json_encode($user)) ?>)"><i class="fas fa-edit"></i> Edit</button>
                        <form method="POST" style="display:inline;" onsubmit="return confirm('Delete this user?');">
                            <input type="hidden" name="delete_user_id" value="<?= $user['id'] ?>">
                            <button type="submit" class="btn btn-delete" <?= $user['id'] == $_SESSION['user_id'] ? 'disabled' : '' ?>><i class="fas fa-trash"></i> Delete</button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <div class="overlay" id="overlay"></div>
        <div class="form-popup" id="userFormPopup">
            <h2 id="formTitle">Add User</h2>
            <form method="POST" id="userForm">
                <input type="hidden" name="user_id" id="user_id">
                <div class="form-group">
                    <label>Username</label>
                    <input type="text" name="username" id="username" required>
                </div>
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" id="email" required>
                </div>
                <div class="form-group">
                    <label>Role</label>
                    <select name="role" id="role" required>
                        <option value="buyer">Buyer</option>
                        <option value="seller">Seller</option>
                        <option value="admin">Admin</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="password" id="password" required>
                </div>
                <div class="form-actions">
                    <button type="button" class="btn" onclick="closeUserForm()">Cancel</button>
                    <button type="submit" class="btn btn-add" name="save_user"><i class="fas fa-save"></i> Save</button>
                </div>
            </form>
        </div>
    </div>
    <script>
        function openUserForm(user) {
            document.getElementById('overlay').classList.add('active');
            document.getElementById('userFormPopup').classList.add('active');
            if (user) {
                document.getElementById('formTitle').textContent = 'Edit User';
                document.getElementById('user_id').value = user.id;
                document.getElementById('username').value = user.username;
                document.getElementById('email').value = user.email;
                document.getElementById('role').value = user.role;
                document.getElementById('password').required = false;
            } else {
                document.getElementById('formTitle').textContent = 'Add User';
                document.getElementById('user_id').value = '';
                document.getElementById('username').value = '';
                document.getElementById('email').value = '';
                document.getElementById('role').value = 'buyer';
                document.getElementById('password').required = true;
            }
        }
        function closeUserForm() {
            document.getElementById('overlay').classList.remove('active');
            document.getElementById('userFormPopup').classList.remove('active');
        }
        document.getElementById('overlay').onclick = closeUserForm;
    </script>
</body>
</html>