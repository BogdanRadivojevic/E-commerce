<p align="center">
  <a href="https://laravel.com" target="_blank">
    <img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo">
  </a>
</p>

<p align="center">
  <a href="https://github.com/laravel/framework/actions">
    <img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status">
  </a>
  <a href="https://packagist.org/packages/laravel/framework">
    <img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads">
  </a>
  <a href="https://packagist.org/packages/laravel/framework">
    <img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version">
  </a>
  <a href="https://packagist.org/packages/laravel/framework">
    <img src="https://img.shields.io/packagist/l/laravel/framework" alt="License">
  </a>
</p>

# 🛒 E-Commerce Web Application

This is a full-stack e-commerce web application built with **Laravel**, **TailwindCSS**, and **Blade components**.  
It allows users to browse products, manage a shopping cart, place orders, and administrators to manage products, services, and view dashboards.

---

## ✨ Features

- User authentication (register, login, logout)
- Product listing, details, and search
- Shopping cart & checkout
- Order history & PDF report generation
- Admin dashboard
- Admin CRUD for products and services
- Notifications

---

## 🖥️ Tech Stack

- **Backend:** Laravel
- **Frontend:** Blade templates + TailwindCSS
- **Database:** SQlite
- **Package Managers:** Composer & npm

---

## 🚀 Installation & Setup

### Prerequisites
✅ PHP (added to system variables)  
✅ Composer  
✅ Node.js & npm  

> 💡 *Tip: You can also use [Laravel Herd](https://herd.laravel.com/) if PHP is not configured globally.*

---

### Steps

```bash
# Clone the repository
git clone https://github.com/BogdanRadivojevic/E-commerce.git
cd e-commerce

# Install PHP dependencies if needed
composer install

# Install frontend dependencies if needed
npm install

# Copy .env and generate app key
cp .env.example .env
php artisan key:generate

# Run migrations
php artisan migrate

# (Optional) Seed fake data
php artisan db:seed

# Create storage links, so the uploaded files are accessible
php artisan storage:link

# Start servers
php artisan serve
npm run dev
```

## 👤 Author

[![Email](https://img.shields.io/badge/Email-radivojevic.bogdan1@gmail.com-blue?style=for-the-badge&logo=gmail)](mailto:radivojevic.bogdan1@gmail.com)  
[![GitHub](https://img.shields.io/badge/GitHub-BogdanRadivojevic-181717?style=for-the-badge&logo=github)](https://github.com/BogdanRadivojevic)  
[![LinkedIn](https://img.shields.io/badge/LinkedIn-Bogdan%20Radivojevi%C4%87-0077B5?style=for-the-badge&logo=linkedin)](https://www.linkedin.com/in/bogdan-radivojevi%C4%87-4678a6260/)
---

⭐ *Thank you for checking out this project!*
