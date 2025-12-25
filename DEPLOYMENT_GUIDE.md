# 🚀 PulseBuy - Complete Deployment Guide

## Overview
This guide covers deploying your complete PulseBuy e-commerce project to GitHub, including both the full-stack PHP application and the static demo.

## 📁 Project Structure
```
PulseBuy_ecommerce-main/
├── pulsebuy-demo/          # Frontend demo (deployed to GitHub Pages)
├── config/                 # Database configuration
├── cart/                   # Shopping cart functionality  
├── order/                  # Order processing
├── orders/                 # Order management
├── payment/                # Payment processing
├── products/               # Product management
├── reports/                # Analytics & reports
├── scripts/                # Database seeding
├── src/                    # Static assets
├── templates/              # PHP templates
├── admin_dashboard.php     # Admin panel
├── buyer_dashboard.php     # Buyer panel
├── seller_dashboard.php    # Seller panel
├── db_schema.sql           # Database schema
├── docker-compose.yml      # Docker configuration
└── README.md              # Project documentation
```

## 🎯 Deployment Options

### Option 1: Full Stack Deployment (PHP + MySQL)
For the complete application with database functionality:

#### Requirements:
- **Server**: Apache/Nginx with PHP 7.4+
- **Database**: MySQL 5.7+ or MariaDB 10.3+
- **PHP Extensions**: PDO, PDO_MySQL, mbstring, openssl

#### Steps:
1. **Upload all files** to your web server
2. **Import database** using `db_schema.sql`
3. **Configure database** in `config/db.php`
4. **Set up Docker** (optional):
   ```bash
   docker-compose up -d
   ```

### Option 2: Static Demo Deployment (GitHub Pages)
For showcasing frontend functionality only:

#### Already Implemented ✅
Your `pulsebuy-demo/` folder is ready for GitHub Pages deployment.

## 🔗 Repository Setup

### For Complete Project Repository:

1. **Create new repository** on GitHub:
   ```bash
   # Repository name: pulsebuy-ecommerce
   # Description: Complete e-commerce marketplace platform
   ```

2. **Initialize and push**:
   ```bash
   git init
   git add .
   git commit -m "Initial PulseBuy e-commerce platform

   - Complete PHP backend with authentication
   - MySQL database schema and seeding
   - Shopping cart and order management
   - Admin, seller, and buyer dashboards
   - Payment processing integration
   - Reports and analytics
   - Responsive frontend design
   - Docker containerization support"
   
   git remote add origin https://github.com/YOUR-USERNAME/pulsebuy-ecommerce.git
   git branch -M main
   git push -u origin main
   ```

### For Demo-Only Repository:

1. **Create demo repository**:
   ```bash
   # Repository name: pulsebuy-demo
   # Description: PulseBuy e-commerce demo - Frontend showcase
   ```

2. **Push demo folder**:
   ```bash
   cd pulsebuy-demo
   git init
   git add .
   git commit -m "PulseBuy E-commerce Demo - Complete Frontend Showcase

   Features:
   - Role-based authentication (buyer/seller/admin)
   - Responsive product catalog
   - Shopping cart functionality
   - User dashboards
   - Wishlist management
   - Order tracking
   
   Demo Credentials:
   - buyer@example.com / buyer123
   - seller@example.com / seller123  
   - admin@example.com / admin123"
   
   git remote add origin https://github.com/YOUR-USERNAME/pulsebuy-demo.git
   git branch -M main
   git push -u origin main
   ```

## 📋 GitHub Pages Setup (for Demo)

After pushing your demo repository:

1. **Go to repository Settings**
2. **Navigate to Pages**
3. **Source**: Deploy from a branch
4. **Branch**: main
5. **Folder**: / (root)
6. **Save**

Your demo will be available at:
```
https://YOUR-USERNAME.github.io/pulsebuy-demo
```

## 🛠️ Environment Configuration

### For Production Deployment:

1. **Database Configuration** (`config/db.php`):
   ```php
   <?php
   $host = 'your-production-db-host';
   $user = 'your-production-db-user';
   $pass = 'your-production-db-password';
   $db_name = 'pulsebuy_production';
   ?>
   ```

2. **Security Settings**:
   - Update all default passwords
   - Configure HTTPS/SSL certificates
   - Set proper file permissions (644 for files, 755 for directories)

3. **PHP Configuration**:
   ```ini
   ; Recommended PHP settings
   memory_limit = 256M
   upload_max_filesize = 10M
   post_max_size = 10M
   max_execution_time = 300
   ```

## 🐳 Docker Deployment (Optional)

If using Docker for deployment:

1. **Build and run**:
   ```bash
   docker-compose up --build -d
   ```

2. **Access application**:
   - Web: http://localhost:8080
   - Database: localhost:3306

## 🔐 Security Checklist

Before deploying to production:

- [ ] Change all default passwords
- [ ] Update database credentials
- [ ] Configure HTTPS/SSL
- [ ] Set up proper file permissions
- [ ] Enable PHP error logging
- [ ] Configure firewall rules
- [ ] Set up regular database backups
- [ ] Update CORS settings if needed

## 📊 Demo Testing

Test your deployment using these credentials:

| Role | Email | Password | Features |
|------|-------|----------|----------|
| **Buyer** | buyer@example.com | buyer123 | Browse, cart, orders, wishlist |
| **Seller** | seller@example.com | seller123 | Add products, sales, inventory |
| **Admin** | admin@example.com | admin123 | User management, reports |

## 🚨 Troubleshooting

### Common Issues:

**Database Connection Error**:
- Check `config/db.php` credentials
- Verify MySQL service is running
- Ensure database exists

**File Upload Issues**:
- Check directory permissions (assets/uploads/)
- Verify PHP upload settings
- Check available disk space

**Authentication Problems**:
- Verify session configuration
- Check browser JavaScript is enabled
- Clear localStorage for demo testing

## 📞 Support

For deployment issues:
1. Check server error logs
2. Verify database connectivity
3. Test with simple PHP file
4. Check file permissions

---

**Ready for production deployment! 🚀**

*Choose the deployment method that best fits your needs: complete stack for full functionality or demo-only for showcasing.*