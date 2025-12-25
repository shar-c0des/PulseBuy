<?php
session_start();
require_once 'config/db.php';

// Verify user login status
if (!isset($_SESSION['user_id'])) {
    header("Location: loginSignup.php");
    exit;
}

$userId = $_SESSION['user_id'];
$wishlistItems = [];

try {
    // Query user wishlist
    $stmt = $pdo->prepare("
        SELECT w.id as wishlist_id, p.* 
        FROM wishlist w 
        JOIN products p ON w.product_id = p.id 
        WHERE w.user_id = ?
    ");
    $stmt->execute([$userId]);
    $wishlistItems = $stmt->fetchAll();
} catch (PDOException $e) {
    $error = "Failed to retrieve wishlist: " . $e->getMessage();
}

// Handle remove wishlist item
if (isset($_GET['remove']) && is_numeric($_GET['remove'])) {
    $wishlistId = $_GET['remove'];
    try {
        $stmt = $pdo->prepare("DELETE FROM wishlist WHERE id = ? AND user_id = ?");
        $stmt->execute([$wishlistId, $userId]);
        header("Location: wishlist.php");
        exit;
    } catch (PDOException $e) {
        $error = "Failed to remove item: " . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Wishlist | PulseBuy</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-blue: #0056E0;
            --secondary-blue: #1A75FF;
            --accent-yellow: #FFC107;
            --accent-green: #00C853;
            --accent-red: #FF3D00;
            --background: #F9FAFB;
            --white: #FFFFFF;
            --border-color: #F1F5F9;
            --dark-text: #1E293B;
            --medium-text: #64748B;
            --light-text: #94A3B8;
            --shadow-sm: 0 1px 2px rgba(0,0,0,0.05);
            --shadow-md: 0 4px 6px -1px rgba(0,0,0,0.1), 0 2px 4px -1px rgba(0,0,0,0.06);
            --radius: 12px;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background-color: var(--background);
            color: var(--dark-text);
            line-height: 1.6;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* --- Header & Navigation --- */
        .header {
            background: var(--white);
            border-bottom: 1px solid var(--border-color);
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .nav-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            height: 72px;
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 22px;
            font-weight: 800;
            color: var(--primary-blue);
            text-decoration: none;
            letter-spacing: -0.5px;
        }

        .logo i {
            color: var(--accent-yellow);
            font-size: 24px;
        }

        .user-actions {
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .user-link {
            display: flex;
            align-items: center;
            gap: 6px;
            color: var(--medium-text);
            text-decoration: none;
            font-weight: 500;
            padding: 8px 12px;
            border-radius: 8px;
            transition: all 0.2s ease;
            font-size: 13px;
        }

        .user-link:hover {
            background: #F8FAFC;
            color: var(--primary-blue);
        }

        .user-link.active {
            color: var(--primary-blue);
            font-weight: 600;
        }

        /* --- Main Content --- */
        .main-content {
            max-width: 1200px;
            margin: 0 auto;
            padding: 32px 24px;
            width: 100%;
            flex: 1;
        }

        .page-header {
            margin-bottom: 28px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .title-group h1 {
            font-size: 24px;
            font-weight: 700;
            color: var(--dark-text);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .title-group h1 i {
            color: var(--accent-red);
            font-size: 20px;
        }

        .wishlist-count {
            color: var(--light-text);
            font-size: 14px;
            margin-top: 2px;
        }

        /* --- Product Grid --- */
        .wishlist-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
            gap: 20px;
        }

        .wishlist-item {
            background: var(--white);
            border-radius: var(--radius);
            border: 1px solid var(--border-color);
            transition: all 0.2s ease;
            position: relative;
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }

        .wishlist-item:hover {
            border-color: #E2E8F0;
            box-shadow: var(--shadow-md);
        }

        .product-image-wrapper {
            position: relative;
            padding-top: 100%;
            background: #FBFBFC;
            overflow: hidden;
        }

        .product-image-wrapper img {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: contain;
            padding: 16px;
        }

        .badge-container {
            position: absolute;
            top: 10px;
            left: 10px;
            display: flex;
            flex-direction: column;
            gap: 4px;
            z-index: 2;
        }

        .badge {
            padding: 2px 8px;
            border-radius: 4px;
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }

        .badge.sale {
            background: var(--accent-red);
            color: var(--white);
        }

        .badge.trending {
            background: var(--accent-green);
            color: var(--white);
        }

        .wishlist-btn {
            position: absolute;
            top: 10px;
            right: 10px;
            background: var(--white);
            border: none;
            border-radius: 50%;
            width: 36px;
            height: 36px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.2s ease;
            box-shadow: var(--shadow-sm);
            z-index: 3;
        }

        .wishlist-btn:hover {
            background: var(--accent-red);
            color: var(--white);
        }

        .product-info {
            padding: 16px;
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .product-title {
            font-size: 14px;
            font-weight: 600;
            color: var(--dark-text);
            margin-bottom: 8px;
            line-height: 1.4;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .product-price {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 12px;
        }

        .current-price {
            font-size: 18px;
            font-weight: 700;
            color: var(--primary-blue);
        }

        .original-price {
            font-size: 14px;
            color: var(--light-text);
            text-decoration: line-through;
        }

        .discount {
            background: var(--accent-red);
            color: var(--white);
            padding: 2px 6px;
            border-radius: 4px;
            font-size: 11px;
            font-weight: 700;
        }

        .add-to-cart-btn {
            background: var(--primary-blue);
            color: var(--white);
            border: none;
            border-radius: 8px;
            padding: 10px 16px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            margin-top: auto;
        }

        .add-to-cart-btn:hover {
            background: var(--secondary-blue);
            transform: translateY(-1px);
        }

        /* --- Empty State --- */
        .empty-state {
            text-align: center;
            padding: 80px 20px;
            color: var(--medium-text);
        }

        .empty-state i {
            font-size: 64px;
            color: var(--light-text);
            margin-bottom: 20px;
        }

        .empty-state h3 {
            font-size: 20px;
            font-weight: 600;
            color: var(--dark-text);
            margin-bottom: 8px;
        }

        .empty-state p {
            margin-bottom: 24px;
            color: var(--medium-text);
        }

        .btn-primary {
            background: var(--primary-blue);
            color: var(--white);
            padding: 12px 24px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.2s ease;
        }

        .btn-primary:hover {
            background: var(--secondary-blue);
            transform: translateY(-1px);
        }

        /* --- Footer --- */
        .footer {
            background: var(--dark-text);
            color: var(--white);
            padding: 40px 0 20px;
            margin-top: auto;
        }

        .footer-content {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 24px;
        }

        .footer-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 32px;
            margin-bottom: 32px;
        }

        .footer-section h4 {
            font-size: 16px;
            font-weight: 600;
            margin-bottom: 16px;
            color: var(--accent-yellow);
        }

        .footer-section p,
        .footer-section a {
            color: #94A3B8;
            text-decoration: none;
            line-height: 1.6;
            margin-bottom: 8px;
            display: block;
        }

        .footer-section a:hover {
            color: var(--accent-yellow);
        }

        .footer-bottom {
            border-top: 1px solid #374151;
            padding-top: 20px;
            text-align: center;
            color: #9CA3AF;
            font-size: 14px;
        }

        /* --- Responsive Design --- */
        @media (max-width: 768px) {
            .nav-container {
                padding: 0 16px;
            }

            .main-content {
                padding: 24px 16px;
            }

            .wishlist-grid {
                grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
                gap: 16px;
            }

            .page-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 8px;
            }
        }

        @media (max-width: 480px) {
            .wishlist-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header class="header">
        <div class="nav-container">
            <a href="index.php" class="logo">
                <i class="fas fa-bolt"></i> Pulse<span>Buy</span>
            </a>
            
            <div class="user-actions">
                <a href="index.php" class="user-link">
                    <i class="fas fa-home"></i> Home
                </a>
                <a href="products.php" class="user-link">
                    <i class="fas fa-shopping-bag"></i> Products
                </a>
                <a href="cart.php" class="user-link">
                    <i class="fas fa-shopping-cart"></i> Cart
                </a>
                <a href="wishlist.php" class="user-link active">
                    <i class="fas fa-heart"></i> Wishlist
                </a>
                <a href="profile.php" class="user-link">
                    <i class="fas fa-user"></i> <?php echo htmlspecialchars($_SESSION['username'] ?? 'Profile'); ?>
                </a>
                <a href="logout.php" class="user-link">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </a>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="main-content">
        <div class="page-header">
            <div class="title-group">
                <h1>
                    <i class="fas fa-heart"></i>
                    My Wishlist
                </h1>
                <div class="wishlist-count">
                    <?php echo count($wishlistItems); ?> <?php echo count($wishlistItems) == 1 ? 'item' : 'items'; ?> saved
                </div>
            </div>
        </div>

        <?php if (isset($error)): ?>
            <div style="background: #FEF2F2; border: 1px solid #FECACA; color: #B91C1C; padding: 16px; border-radius: 8px; margin-bottom: 24px;">
                <strong>Error!</strong> <?php echo htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>

        <?php if (empty($wishlistItems)): ?>
            <div class="empty-state">
                <i class="fas fa-heart"></i>
                <h3>Your wishlist is empty</h3>
                <p>Start adding products you love to your wishlist</p>
                <a href="products.php" class="btn-primary">
                    <i class="fas fa-shopping-bag"></i>
                    Start Shopping
                </a>
            </div>
        <?php else: ?>
            <div class="wishlist-grid">
                <?php foreach ($wishlistItems as $item): ?>
                    <div class="wishlist-item">
                        <div class="product-image-wrapper">
                            <img src="<?php echo $item['image_path'] ?: 'https://picsum.photos/id/26/300/300'; ?>" 
                                alt="<?php echo htmlspecialchars($item['title']); ?>">
                            
                            <div class="badge-container">
                                <?php if (rand(1, 3) == 1): ?>
                                    <span class="badge sale">Sale</span>
                                <?php elseif (rand(1, 3) == 2): ?>
                                    <span class="badge trending">Trending</span>
                                <?php endif; ?>
                            </div>
                            
                            <button onclick="location.href='wishlist.php?remove=<?php echo $item['wishlist_id']; ?>'" 
                                class="wishlist-btn" title="Remove from wishlist">
                                <i class="fas fa-heart"></i>
                            </button>
                        </div>
                        
                        <div class="product-info">
                            <h3 class="product-title">
                                <?php echo htmlspecialchars($item['title']); ?>
                            </h3>
                            
                            <div class="product-price">
                                <span class="current-price">R<?php echo number_format($item['price'], 2); ?></span>
                                <?php if (rand(1, 3) == 1): ?>
                                    <?php $originalPrice = $item['price'] * 1.2; ?>
                                    <span class="original-price">R<?php echo number_format($originalPrice, 2); ?></span>
                                    <span class="discount">20% OFF</span>
                                <?php endif; ?>
                            </div>
                            
                            <button class="add-to-cart-btn" onclick="addToCart(<?php echo $item['id']; ?>)">
                                <i class="fas fa-shopping-cart"></i>
                                Add to Cart
                            </button>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </main>

    <!-- Footer -->
    <footer class="footer">
        <div class="footer-content">
            <div class="footer-grid">
                <div class="footer-section">
                    <h4>About PulseBuy</h4>
                    <p>South Africa's leading C2C marketplace connecting buyers and sellers across the country.</p>
                </div>
                <div class="footer-section">
                    <h4>Quick Links</h4>
                    <a href="index.php">Home</a>
                    <a href="products.php">Products</a>
                    <a href="wishlist.php">Wishlist</a>
                    <a href="cart.php">Cart</a>
                </div>
                <div class="footer-section">
                    <h4>Customer Service</h4>
                    <a href="#">Help Center</a>
                    <a href="#">Contact Us</a>
                    <a href="#">Returns</a>
                    <a href="#">Shipping Info</a>
                </div>
                <div class="footer-section">
                    <h4>Follow Us</h4>
                    <a href="#"><i class="fab fa-facebook"></i> Facebook</a>
                    <a href="#"><i class="fab fa-twitter"></i> Twitter</a>
                    <a href="#"><i class="fab fa-instagram"></i> Instagram</a>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; <?php echo date('Y'); ?> PulseBuy. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script>
        function addToCart(productId) {
            // Add to cart functionality
            alert('Product added to cart!');
        }
    </script>
</body>
</html>