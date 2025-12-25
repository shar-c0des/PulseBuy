# 🛒 PulseBuy - E-commerce Marketplace Demo

> **South Africa's Leading C2C Marketplace Platform**

A fully functional frontend demo of an e-commerce marketplace built with HTML, CSS, and JavaScript. Features role-based authentication, responsive design, and comprehensive user dashboards for buyers, sellers, and administrators.

## 🚀 Live Demo

**[View Live Demo](https://shar-c0des.github.io/PulseBuy-demo)**

## ✨ Features

### 🎯 User Roles & Authentication
- **Buyer Dashboard**: Browse products, manage cart, track orders, wishlist
- **Seller Dashboard**: Add/manage products, view sales analytics, inventory tracking
- **Admin Dashboard**: User management, platform analytics, system oversight
- **Local Storage Authentication**: Demo-ready authentication system

### 🛍️ Core E-commerce Features
- **Product Catalog**: Browse products with categories and search
- **Shopping Cart**: Add/remove items, quantity management
- **Order Management**: Order history and tracking
- **Wishlist**: Save favorite products for later
- **Responsive Design**: Works seamlessly on desktop, tablet, and mobile

### 🎨 UI/UX Highlights
- **Modern Design**: Clean, professional interface
- **Responsive Layout**: Mobile-first design approach
- **Interactive Elements**: Smooth animations and hover effects
- **Accessibility**: Proper semantic HTML and keyboard navigation

## 🔑 Demo Login Credentials

| Role | Email | Password | Access |
|------|-------|----------|--------|
| **Buyer** | `buyer@example.com` | `buyer123` | Browse products, manage cart, view orders |
| **Seller** | `seller@example.com` | `seller123` | Add products, view sales, manage inventory |
| **Admin** | `admin@example.com` | `admin123` | Full platform management and analytics |

## 🏗️ Technology Stack

- **Frontend**: HTML5, CSS3, JavaScript (ES6+)
- **Styling**: Custom CSS with CSS Grid & Flexbox
- **Icons**: Font Awesome 6.4.0
- **Fonts**: Google Fonts (Noto Sans, Poppins)
- **Storage**: localStorage for demo data persistence
- **Deployment**: GitHub Pages

## 📁 Project Structure

```
pulsebuy-demo/
├── index.html              # Landing page
├── loginSignup.html        # Authentication pages
├── buyer.html             # Buyer role selection
├── buyer_dashboard.html   # Buyer dashboard
├── seller.html            # Seller role selection  
├── seller_dashboard.html  # Seller dashboard
├── admin.html             # Admin dashboard
├── cart.html             # Shopping cart
├── products.html         # Product catalog
├── wishlist.html         # Wishlist management
├── logout.html           # Logout confirmation
├── auth_test.html        # Authentication testing
├── auth.js              # Authentication logic
├── test_auth.js         # Auth testing utilities
└── assets/
    └── uploads/
        └── prodimg_6861e535ca1341.00574175.png
```

## 🚀 Getting Started

### Quick Start
1. **Clone the repository**
   ```bash
   git clone https://github.com/shar-c0des/pulsebuy-demo.git
   cd pulsebuy-demo
   ```

2. **Serve locally** (optional)
   ```bash
   # Using Python 3
   python -m http.server 8080
   
   # Using Node.js
   npx serve .
   ```

3. **Open in browser**
   Navigate to `http://localhost:8080` or open `index.html` directly

### GitHub Pages Deployment
1. Fork/clone this repository to your GitHub account
2. Go to repository Settings → Pages
3. Select "Deploy from a branch" → main branch → / (root)
4. Your site will be available at `https://your-username.github.io/pulsebuy-demo`

## 🎮 How to Use

### For Buyers
1. Login with buyer credentials
2. Browse products in the catalog
3. Add items to cart and manage quantities
4. View order history and manage wishlist

### For Sellers  
1. Login with seller credentials
2. Access seller dashboard
3. Add new products with images and descriptions
4. Monitor sales and manage inventory

### For Administrators
1. Login with admin credentials
2. Access admin dashboard
3. View platform analytics and user management
4. Generate reports and manage system settings

## 🛠️ Customization

### Adding Products
Edit the demo data in `auth.js` to add more products:
```javascript
const demoProducts = [
    {
        id: 4,
        name: "Your Product",
        price: 99.99,
        category: "Electronics",
        image: "assets/uploads/your-image.jpg"
    }
];
```

### Styling Changes
- Modify CSS variables in each HTML file for color schemes
- Update Google Fonts imports for typography changes
- Customize component styles in the embedded `<style>` sections

## 🔧 Development

### Local Testing
```bash
# Start local server
python -m http.server 8080

# Open browser
open http://localhost:8080
```

### Authentication Testing
Visit `auth_test.html` to test all authentication features programmatically.

## 📱 Browser Compatibility

- ✅ Chrome 60+
- ✅ Firefox 55+ 
- ✅ Safari 12+
- ✅ Edge 79+
- ✅ Mobile browsers (iOS Safari, Chrome Mobile)

## 🤝 Contributing

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

## 📄 License

This project is licensed under the MIT License - see the [LICENSE](../LICENSE) file for details.

## 🙏 Acknowledgments

- **Font Awesome** for the comprehensive icon set
- **Google Fonts** for beautiful typography
- **GitHub Pages** for free hosting and deployment
- The e-commerce community for design inspiration

## 📞 Support

If you encounter any issues or have questions:
- Open an issue on GitHub
- Check the demo credentials and try refreshing the page
- Ensure JavaScript is enabled in your browser

---

**Built with ❤️ for the South African e-commerce community**

*Last updated: December 2025*