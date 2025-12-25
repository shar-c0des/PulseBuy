<h1 align = 'center'>
  PulseBuy E-commerce Platform
</h1>

<div align="center">

![GitHub stars](https://img.shields.io/github/stars/shar-c0des/PulseBuy.svg?style=social&label=Star)
![GitHub forks](https://img.shields.io/github/forks/shar-c0des/PulseBuy.svg?style=social&label=Fork)
![GitHub issues](https://img.shields.io/github/issues/shar-c0des/PulseBuy)
![GitHub license](https://img.shields.io/github/license/shar-c0des/PulseBuy)

**A C2C e-commerce platform that features multi-role user management, product catalog, shopping cart functionality, and administrative controls - built with modern web technologies.**

[![PHP](https://img.shields.io/badge/PHP-777BB4?style=flat-square&logo=php&logoColor=white)](https://php.net)
[![MySQL](https://img.shields.io/badge/MySQL-4479A1?style=flat-square&logo=mysql&logoColor=white)](https://mysql.com)
[![HTML5](https://img.shields.io/badge/HTML5-E34F26?style=flat-square&logo=html5&logoColor=white)](https://developer.mozilla.org/en-US/docs/Web/HTML)
[![CSS3](https://img.shields.io/badge/CSS3-1572B6?style=flat-square&logo=css3&logoColor=white)](https://developer.mozilla.org/en-US/docs/Web/CSS)
[![JavaScript](https://img.shields.io/badge/JavaScript-F7DF1E?style=flat-square&logo=javascript&logoColor=black)](https://javascript.com)
[![Docker](https://img.shields.io/badge/Docker-2496ED?style=flat-square&logo=docker&logoColor=white)](https://docker.com)

</div>

---

## Table of Contents

1. [Project Description](#project-description)
2. [Core Features](#core-features)
3. [Tech Stack](#tech-stack)
4. [Quick Start](#quick-start)
5. [Design Inspiration](#design-inspiration)
6. [User Roles & Access](#user-roles-&-access)
7. [Project Structure](#project-Structure)
8. [Database Schema](#database-schema)
9. [Development](#development)
10. [Project Documentation](#project-documentation)
11. [Contributing](#contributing)
12. [License](#license)

---

##  Project Description

**PulseBuy** is a full-featured e-commerce platform designed to provide a seamless online shopping experience for buyers while enabling sellers to manage their products efficiently and administrators to oversee the entire system.

### Project Goals
- **Multi-Role System**: Support for Admins, Buyers, and Sellers with role-specific dashboards
- **Complete Shopping Experience**: From product browsing to order completion
- **Scalable Architecture**: Built with PHP and MySQL for reliability and performance
- **User-Friendly Interface**: Intuitive design for all user types
- **Comprehensive Management**: Product, order, and user management capabilities

---

## Core Features

| Category | Features |
|----------|----------|
| *User Management* | • Multi-role authentication system<br>• User registration & login<br>• Profile management<br>• Role-based access control |
| *Product Management* | • Complete product catalog<br>• Add, edit, delete products<br>• Image upload functionality<br>• Inventory tracking |
| *Shopping Experience** | • Interactive shopping cart<br>• Wishlist functionality<br>• Order processing workflow<br>• Payment integration |
| *Analytics & Reports** | • Sales analytics dashboard<br>• Order history tracking<br>• Admin reporting system<br>• Performance metrics |
| *Multi-Vendor Support** | • Dedicated seller dashboard<br>• Individual product management<br>• Sales tracking per seller<br>• Vendor performance reports |

---

## Tech  Stack

<div align="center">

| Layer | Technology | Purpose |
|-------|------------|---------|
| *Backend** | ![PHP](https://img.shields.io/badge/PHP-777BB4?style=flat&logo=php&logoColor=white) | Server-side logic and API endpoints |
| *Database** | ![MySQL](https://img.shields.io/badge/MySQL-4479A1?style=flat&logo=mysql&logoColor=white) | Data storage and management |
| *Frontend** | ![HTML5](https://img.shields.io/badge/HTML5-E34F26?style=flat&logo=html5&logoColor=white) | Page structure and markup |
| *Styling** | ![CSS3](https://img.shields.io/badge/CSS3-1572B6?style=flat&logo=css3&logoColor=white) | Visual design and layout |
| *Scripting** | ![JavaScript](https://img.shields.io/badge/JavaScript-F7DF1E?style=flat&logo=javascript&logoColor=black) | Interactive functionality |
| *Containerization** | ![Docker](https://img.shields.io/badge/Docker-2496ED?style=flat&logo=docker&logoColor=white) | Development environment setup |

</div>

---

##  Quick Start

### Prerequisites
- [Docker](https://www.docker.com/products/docker-desktop) installed
- [Docker Compose](https://docs.docker.com/compose/) (included with Docker)
- Web browser with JavaScript enabled

### Installation & Setup

1. **Clone the repository:**
```bash
git clone https://github.com/shar-c0des/PulseBuy.git
cd PulseBuy
```

2. **Build and start the containers:**
```bash
docker-compose up --build
```

3. **Access the application:**
   - **Web Application**: [http://localhost:8080](http://localhost:8080)
   - **phpMyAdmin**: [http://localhost:8081](http://localhost:8081)
     - Server: `db`
     - Username: `pulseuser` or `root`
     - Password: `pulsepass` or `rootpass`

4. **Database Configuration:**
   - Host: `db`
   - Database: `pulsebuy`
   - User: `pulseuser`
   - Password: `pulsepass`

5. **Import database schema:**
   - Use phpMyAdmin at localhost:8081
   - Import the `db_schema.sql` file

6. **Stop the containers:**
```bash
docker-compose down
```

---

## Design Inspiration

<div align="center">

### Research & Analysis

During the design and development phase, I analyzed leading e-commerce platforms to understand best practices and user experience patterns:

<table style="width: 100%; border-collapse: collapse; margin: 20px 0;">
<tr style="background-color: #f8f9fa;">
<td style="padding: 15px; text-align: center; border: 1px solid #dee2e6;">
<a href="https://world.taobao.com" target="_blank">
<img src="https://dfhlogistics.com/wp-content/uploads/2025/01/taobao-webiste-1-scaled.jpg?text=Taobao" alt="Taobao" style="max-width: 50%;">
<br><strong>Taobao</strong>
</a>
</td>
<td style="padding: 15px; text-align: center; border: 1px solid #dee2e6;">
<a href="https://www.gmarket.co.kr" target="_blank">
<img src="https://www.you.co/sg/wp-content/uploads/sites/2/2021/05/titleimage.png?text=Gmarket" alt="Gmarket" style="max-width: 100%;">
<br><strong>Gmarket</strong>
</a>
</td>
</tr>
</table>

</div>

### Implemented Features from Research

#### From **Taobao**:
- **Advanced Shopping Cart**: Multi-item selection and quantity management
- **Product Rating System**: Customer feedback and rating display
- **Multi-vendor Marketplace**: Individual seller stores and management
- **Mobile-Responsive Design**: Cross-device compatibility

#### From **Gmarket**:
- **Category-Based Navigation**: Structured product categorization
- **Sales Analytics Dashboard**: Real-time sales tracking and reporting
- **Integrated Payment Processing**: Streamlined checkout experience
- **Order Tracking System**: Comprehensive order status monitoring

###  Research Insights

The combination of these platforms influenced PulseBuy's architecture:
- **User-Centric Design**: Focus on seamless user experience
- **Scalable Architecture**: Support for multiple vendors and large product catalogs
- **Data-Driven Decisions**: Comprehensive analytics for business insights
- **Modern Interface**: Clean, intuitive design patterns

---

##  User Roles & Access

###  **Admin Dashboard** (`admin_dashboard.php`)
- *Complete System Access*: Full platform control and configuration
- *User Management*: Account creation, modification, and role assignment
- *Product Oversight*: Review, approve, and manage all products
- *Analytics & Reports*: Comprehensive sales and usage statistics
- *System Configuration*: Database management and platform settings

###  **Buyer Dashboard** (`buyer_dashboard.php`)
- *Product Browsing*: Search, filter, and explore product catalog
- *Shopping Cart*: Add, remove, and modify cart items
- *Order Management*: Place orders and track order status
- *Wishlist*: Save and manage favorite products
- *Profile Management*: Update personal information and preferences

###  **Seller Dashboard** (`seller_dashboard.php`)
- *Product Management*: Add, edit, and manage personal product listings
- *Sales Analytics*: Track performance and revenue metrics
- *Order Processing*: Handle orders for seller's products
- *Inventory Control*: Monitor and update stock levels
- *Business Reports*: Access seller-specific analytics and insights

---

##  Project Structure

```
PulseBuy/
├──  Core Files
│   ├── index.php                     # Homepage and landing page
│   ├── loginSignup.php               # User authentication portal
│   ├── register.php                  # User registration
│   ├── logout.php                    # Session termination
│   ├── profile.php                   # User profile management
│   └── products.php                  # Product catalog display
│
├──  Dashboards
│   ├── admin_dashboard.php           # Admin control panel
│   ├── buyer_dashboard.php           # Customer dashboard
│   ├── seller_dashboard.php          # Seller interface
│   ├── buyer_welcome.php             # Buyer welcome page
│   └── seller_welcome.php            # Seller welcome page
│
├──  Shopping Cart
│   ├── cart/
│   │   ├── add.php                   # Add items to cart
│   │   ├── remove.php                # Remove items from cart
│   │   └── view.php                  # View cart contents
│   ├── wishlist.php                  # Wishlist functionality
│   └── order/
│       └── confirmation.php          # Order confirmation page
│
├──  Product Management
│   ├── products/
│   │   ├── add.php                   # Add new products
│   │   ├── edit.php                  # Edit existing products
│   │   ├── delete.php                # Delete products
│   │   ├── list.php                  # Product listing
│   │   ├── manage.php                # Product management
│   │   └── view.php                  # Individual product view
│   │
├──  Order Management
│   ├── orders/
│   │   ├── history.php               # Order history tracking
│   │   ├── sales.php                 # Sales reports
│   │   └── view.php                  # Order details
│   └── payment/
│       └── process.php               # Payment processing
│
├──  Analytics & Reports
│   └── reports/
│       └── generate.php              # Report generation
│
├──  Configuration
│   ├── config/
│   │   └── db.php                    # Database configuration
│   ├── templates/
│   │   ├── header.php                # Site header template
│   │   └── footer.php                # Site footer template
│   └── scripts/
│       └── seed_demo_data.php        # Demo data seeder
│
├──  Database
│   ├── db_schema.sql                 # Complete database schema
│   ├── Dockerfile                    # Docker container setup
│   └── docker-compose.yml            # Multi-container setup
│
└──  Assets
    ├── assets/
    │   └── uploads/                  # User uploaded files
    └── src/
        └── uploads/                  # Source uploads
```

---

##  Database Schema

The PulseBuy platform uses a comprehensive MySQL database with the following main entities:

### Core Tables
- **Users**: User accounts, authentication, and role management
- **Products**: Product catalog with details, pricing, and inventory
- **Categories**: Product categorization and organization
- **Orders**: Order tracking and management system
- **Order_Items**: Individual items within orders
- **Cart**: Shopping cart contents and management
- **Wishlist**: User saved products and preferences
- **Payments**: Payment transaction records
- **Reviews**: Product reviews and ratings system

**Full schema available in**: `db_schema.sql`

---

## 🔧 Development

### Setting Up Development Environment

1. **Fork and clone the repository**
2. **Create a feature branch:**
```bash
git checkout -b feature/your-feature-name
```
3. **Make your changes**
4. **Test thoroughly**
5. **Commit with descriptive message:**
```bash
git commit -m "Add: detailed feature description"
```
6. **Push and create pull request**

### Code Standards
- PHP: Follow PSR-12 coding standards
- SQL: Use prepared statements for security
- HTML/CSS: Semantic markup and responsive design
- JavaScript: ES6+ features and modern practices

---

## Project Documentation

<div align="center">

| Document | Description | Link |
|----------|-------------|------|
|  **Project Proposal** | Initial project scope and requirements | [View Document](https://ev.turnitin.com/student/paper/2602109560/original_submission?lang=en_us) |
|  **Design & Development PPT** | Presentation on design decisions and implementation | [View Presentation](https://mylms.vossie.net/pluginfile.php/1507929/assignsubmission_file/submission_files/199292/ITECA.ppt.pptx?forcedownload=1) |
|  **User Manual** | Comprehensive user guide for all roles | [View Manual](https://mylms.vossie.net/pluginfile.php/1240906/assignsubmission_file/submission_files/184943/user%20manual.pdf?forcedownload=1) |

</div>

---

##  Contributing

I welcome contributions to enhance PulseBuy's functionality and user experience!

### How to Contribute

1. **Fork the repository** to your GitHub account
2. **Create a feature branch** with descriptive name:
   ```bash
   git checkout -b feature/awesome-new-feature
   ```
3. **Implement your changes** following our coding standards
4. **Test thoroughly** across different user roles and scenarios
5. **Submit a pull request** with detailed description of changes

### Contribution Guidelines
- Follow existing code style and conventions
- Add comments for complex logic
- Include appropriate error handling
- Test new features across all user roles
- Update documentation if needed

---

##  License

This project is licensed under the **MIT License** - see the [LICENSE](LICENSE) file for details.

---

##  Acknowledgments

- **PHP Community**: For robust server-side development tools
- **MySQL**: For reliable database management system
- **Docker**: For simplified development environment setup
- **E-commerce Platforms**: Taobao and Gmarket for design inspiration
- **Open Source Community**: For continuous innovation and support

---

##  Support & Contact

For questions, suggestions, or support:
- **Create an Issue**: [GitHub Issues](https://github.com/shar-c0des/PulseBuy/issues)
- **Email**: ngomakapilesharleen703@gmail.com


---

<div align="center">

### ⭐ If you find PulseBuy helpful, please consider giving it a star!

**Made with ❤️ by shar-c0des**

[![GitHub stars](https://img.shields.io/github/stars/shar-c0des/PulseBuy.svg?style=social&label=Star)](https://github.com/shar-c0des/PulseBuy)
[![GitHub forks](https://img.shields.io/github/forks/shar-c0des/PulseBuy.svg?style=social&label=Fork)](https://github.com/shar-c0des/PulseBuy/fork)

---

*Last Updated: December 2024*

</div>
