<?php
session_start();
require_once '../config/db.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: /login.php');
    exit;
}

if (isset($_GET['id'])) {
    $cart_id = (int)$_GET['id'];
    $user_id = (int)$_SESSION['user_id'];

    $stmt = $pdo->prepare('DELETE FROM cart WHERE id = ? AND user_id = ?');
    $stmt->execute([$cart_id, $user_id]);
    header('Location: /cart/view.php');
    exit;
}