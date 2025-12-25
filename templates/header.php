<?php
// Minimal header.php for PulseBuy
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>PulseBuy</title>
</head>
<body>
<!-- Header Start -->
<header>
    <h1>PulseBuy E-commerce</h1>
    <nav>
        <a href="/index.php">Home</a> |
        <a href="/products.php">Products</a> |
        <a href="/cart/view.php">Cart</a> |
        <a href="/profile.php">Profile</a>
    </nav>
</header>
<!-- Header End -->

<script>
    // Mobile menu toggle
    document.addEventListener('DOMContentLoaded', function() {
        const mobileMenuButton = document.getElementById('mobile-menu-button');
        const mobileMenu = document.getElementById('mobile-menu');
        
        if (mobileMenuButton && mobileMenu) {
            mobileMenuButton.addEventListener('click', function() {
                if (mobileMenu.classList.contains('-translate-y-full')) {
                    mobileMenu.classList.remove('-translate-y-full');
                    mobileMenu.classList.add('translate-y-0');
                } else {
                    mobileMenu.classList.remove('translate-y-0');
                    mobileMenu.classList.add('-translate-y-full');
                }
            });
        }
        
        // Mobile dropdown toggle
        const mobileDropdownButton = document.querySelector('.mobile-dropdown-button');
        const mobileDropdownMenu = document.querySelector('.mobile-dropdown-menu');
        
        if (mobileDropdownButton && mobileDropdownMenu) {
            mobileDropdownButton.addEventListener('click', function() {
                mobileDropdownMenu.classList.toggle('hidden');
                const icon = mobileDropdownButton.querySelector('i');
                if (mobileDropdownMenu.classList.contains('hidden')) {
                    icon.classList.remove('fa-chevron-up');
                    icon.classList.add('fa-chevron-down');
                } else {
                    icon.classList.remove('fa-chevron-down');
                    icon.classList.add('fa-chevron-up');
                }
            });
        }
        
        // User dropdown toggle
        const userButton = document.querySelector('.user-button');
        const userDropdown = document.querySelector('.user-dropdown');
        
        if (userButton && userDropdown) {
            userButton.addEventListener('click', function() {
                userDropdown.classList.toggle('active');
            });
            
            // Close dropdown when clicking outside
            document.addEventListener('click', function(event) {
                if (!userButton.contains(event.target) && !userDropdown.contains(event.target)) {
                    userDropdown.classList.remove('active');
                }
            });
        }
        
        // Nav dropdown toggle
        const dropdowns = document.querySelectorAll('.dropdown');
        
        dropdowns.forEach(dropdown => {
            const dropdownLink = dropdown.querySelector('.nav-link');
            const dropdownMenu = dropdown.querySelector('.dropdown-menu');
            
            dropdownLink.addEventListener('click', function(e) {
                e.preventDefault();
                dropdownMenu.classList.toggle('active');
            });
            
            // Close dropdown when clicking outside
            document.addEventListener('click', function(event) {
                if (!dropdown.contains(event.target)) {
                    dropdownMenu.classList.remove('active');
                }
            });
        });
    });
</script>

<style>
    /* Variables */
    :root {
        --primary: #0050b5;       /* Main blue */
        --accent: #ffd166;        /* Accent yellow */
        --dark: #212529;          /* Dark text */
        --light: #f8f9fa;         /* Light background */
        --gray: #e9ecef;          /* Gray border */
        --gray-dark: #495057;     /* Dark gray text */
        --pink: #ff6b6b;          /* Pink accent */
        --white: #ffffff;         /* White */
    }

    /* Global styles */
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: 'Inter', sans-serif;
    }

    body {
        font-size: 16px;
        line-height: 1.5;
        color: var(--dark);
    }

    .container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 15px;
    }

    .flex {
        display: flex;
    }

    .items-center {
        align-items: center;
    }

    .justify-between {
        justify-content: between;
    }

    .mb-4 {
        margin-bottom: 1rem;
    }

    .ml-4 {
        margin-left: 1rem;
    }

    .px-4 {
        padding-left: 1rem;
        padding-right: 1rem;
    }

    .py-3 {
        padding-top: 0.75rem;
        padding-bottom: 0.75rem;
    }

    .rounded-full {
        border-radius: 9999px;
    }

    .hover:bg-gray-100:hover {
        background-color: #f3f4f6;
    }

    .transition-colors {
        transition: color 0.2s ease, background-color 0.2s ease;
    }

    /* Header styles */
    .site-header {
        background-color: var(--white);
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        position: sticky;
        top: 0;
        z-index: 100;
    }

    .header-top {
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
        align-items: center;
        padding: 1.5rem 0;
    }

    .logo {
        display: flex;
        align-items: center;
        text-decoration: none;
        font-size: 1.5rem;
        font-weight: bold;
    }

    .logo i {
        color: var(--primary);
        margin-right: 0.5rem;
    }

    .text-primary {
        color: var(--primary);
    }

    .text-accent {
        color: var(--accent);
    }

    .text-dark {
        color: var(--dark);
    }

    .search-bar {
        position: relative;
    }

    .search-input {
        width: 100%;
        padding: 0.75rem 2.5rem 0.75rem 1rem;
        border: 1px solid var(--gray);
        border-radius: 9999px;
        outline: none;
        transition: border-color 0.2s ease, box-shadow 0.2s ease;
    }

    .search-input:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(0, 80, 181, 0.2);
    }

    .search-button {
        position: absolute;
        right: 1rem;
        top: 50%;
        transform: translateY(-50%);
        background: none;
        border: none;
        cursor: pointer;
        color: var(--gray-dark);
        transition: color 0.2s ease;
    }

    .search-button:hover {
        color: var(--primary);
    }

    .user-actions {
        display: flex;
        align-items: center;
    }

    .cart-link {
        position: relative;
        display: flex;
        align-items: center;
        justify-content: center;
        width: 2.5rem;
        height: 2.5rem;
        border-radius: 50%;
        transition: background-color 0.2s ease;
    }

    .cart-link:hover {
        background-color: var(--light);
    }

    .cart-count {
        position: absolute;
        top: -0.25rem;
        right: -0.25rem;
        background-color: var(--pink);
        color: var(--white);
        font-size: 0.75rem;
        font-weight: bold;
        width: 1.25rem;
        height: 1.25rem;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .cart-tooltip {
        position: absolute;
        bottom: -1.5rem;
        left: 50%;
        transform: translateX(-50%);
        background-color: var(--dark);
        color: var(--white);
        font-size: 0.75rem;
        padding: 0.25rem 0.5rem;
        border-radius: 0.25rem;
        opacity: 0;
        visibility: hidden;
        transition: opacity 0.2s ease, visibility 0.2s ease;
        white-space: nowrap;
    }

    .cart-link:hover .cart-tooltip {
        opacity: 1;
        visibility: visible;
    }

    .user-menu {
        position: relative;
        margin-left: 1rem;
    }

    .user-button {
        display: flex;
        align-items: center;
        background: none;
        border: none;
        cursor: pointer;
        color: var(--dark);
        transition: color 0.2s ease;
    }

    .user-button:hover {
        color: var(--primary);
    }

    .username {
        font-weight: 500;
        margin: 0 0.5rem;
    }

    .user-dropdown {
        position: absolute;
        right: 0;
        top: calc(100% + 0.5rem);
        background-color: var(--white);
        border-radius: 0.5rem;
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        width: 15rem;
        z-index: 100;
        opacity: 0;
        visibility: hidden;
        transform: scale(0.95);
        transform-origin: top right;
        transition: opacity 0.2s ease, visibility 0.2s ease, transform 0.2s ease;
    }

    .user-dropdown.active {
        opacity: 1;
        visibility: visible;
        transform: scale(1);
    }

    .dropdown-item {
        display: flex;
        align-items: center;
        padding: 0.75rem 1rem;
        text-decoration: none;
        color: var(--dark);
        transition: background-color 0.2s ease;
    }

    .dropdown-item:hover {
        background-color: var(--light);
    }

    .text-danger {
        color: var(--pink);
    }

    .login-link, .register-link {
        display: flex;
        align-items: center;
        text-decoration: none;
        padding: 0.5rem 1rem;
        margin-left: 0.5rem;
        transition: background-color 0.2s ease, color 0.2s ease;
    }

    .login-link {
        color: var(--dark);
    }

    .login-link:hover {
        color: var(--primary);
    }

    .register-link {
        background-color: var(--primary);
        color: var(--white);
        border-radius: 9999px;
    }

    .register-link:hover {
        background-color: #004091;
    }

    /* Main navigation styles */
    .main-nav {
        border-top: 1px solid var(--gray);
    }

    .nav-wrapper {
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .nav-list {
        display: flex;
        list-style: none;
        overflow-x: auto;
        scrollbar-width: none;
    }

    .nav-list::-webkit-scrollbar {
        display: none;
    }

    .nav-item {
        position: relative;
    }

    .nav-link {
        display: block;
        padding: 0.75rem 1rem;
        text-decoration: none;
        color: var(--dark);
        font-weight: 500;
        transition: color 0.2s ease;
        white-space: nowrap;
    }

    .nav-link:hover {
        color: var(--primary);
    }

    .dropdown {
        position: relative;
    }

    .dropdown-menu {
        position: absolute;
        left: 0;
        top: calc(100% + 0.5rem);
        background-color: var(--white);
        border-radius: 0.5rem;
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        width: 15rem;
        z-index: 100;
        opacity: 0;
        visibility: hidden;
        transition: opacity 0.2s ease, visibility 0.2s ease;
    }

    .dropdown:hover .dropdown-menu {
        opacity: 1;
        visibility: visible;
    }

    .dropdown-item {
        display: flex;
        align-items: center;
        padding: 0.75rem 1rem;
        text-decoration: none;
        color: var(--dark);
        transition: background-color 0.2s ease;
    }

    .dropdown-item:hover {
        background-color: var(--light);
    }

    .nav-actions {
        display: flex;
        align-items: center;
    }

    .nav-action {
        display: flex;
        align-items: center;
        text-decoration: none;
        color: var(--dark);
        padding: 0.75rem 1rem;
        transition: color 0.2s ease;
    }

    .nav-action:hover {
        color: var(--primary);
    }

    /* Mobile menu styles */
    .mobile-menu-toggle {
        display: none;
    }

    .mobile-menu {
        position: absolute;
        width: 100%;
        left: 0;
        background-color: var(--white);
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        z-index: 50;
        transform: translateY(-100%);
        transition: transform 0.3s ease-in-out;
    }

    .mobile-menu.active {
        transform: translateY(0);
    }

    .mobile-nav-list {
        list-style: none;
    }

    .mobile-nav-item {
        margin-bottom: 0.5rem;
    }

    .mobile-nav-link {
        display: flex;
        align-items: center;
        text-decoration: none;
        color: var(--dark);
        padding: 0.75rem 1rem;
        border-radius: 0.5rem;
        transition: background-color 0.2s ease;
    }

    .mobile-nav-link:hover {
        background-color: var(--light);
    }

    .mobile-dropdown-button {
        display: flex;
        align-items: center;
        justify-content: space-between;
        width: 100%;
        background: none;
        border: none;
        text-align: left;
        color: var(--dark);
        padding: 0.75rem 1rem;
        border-radius: 0.5rem;
        transition: background-color 0.2s ease;
        cursor: pointer;
    }

    .mobile-dropdown-button:hover {
        background-color: var(--light);
    }

    .mobile-dropdown-menu {
        display: none;
        margin-top: 0.5rem;
        margin-left: 1rem;
        border-radius: 0.5rem;
        background-color: var(--light);
    }

    .mobile-dropdown-menu.active {
        display: block;
    }

    .mobile-dropdown-item {
        display: block;
        text-decoration: none;
        color: var(--dark);
        padding: 0.5rem 1rem;
        border-radius: 0.5rem;
        transition: background-color 0.2s ease;
    }

    .mobile-dropdown-item:hover {
        background-color: var(--gray);
    }

    /* Responsive styles */
    @media (max-width: 768px) {
        .header-top {
            flex-direction: column;
        }

        .logo, .search-bar, .user-actions {
            width: 100%;
            margin-bottom: 1rem;
        }

        .search-bar {
            margin: 0 0 1rem;
        }

        .user-actions {
            justify-content: center;
        }

        .main-nav, .nav-actions {
            display: none;
        }

        .mobile-menu-toggle {
            display: flex;
        }
    }
</style>
</body>
</html>