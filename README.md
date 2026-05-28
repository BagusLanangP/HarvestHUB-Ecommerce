# HarvestHUB Ecommerce

HarvestHUB is an agricultural e-commerce platform that connects farmers, buyers, and agricultural experts. It provides a comprehensive marketplace for agricultural products, farm workers, and consultants.

## Key Features

- **Multi-Role User Authentication**: Secure login and registration for different user types (Farmer, Buyer, Admin).
- **Product & Shop Management**: Farmers can create their own shops (`Toko`) and manage their agricultural products.
- **Service Booking**: Find and hire farm workers (`TenagaKerja`) and agricultural consultants (`Konsultan`).
- **Shopping Cart & Order System**: Complete e-commerce experience with shopping cart (`cart`), wishlist (`wishlist`), checkout, and transaction management (`transaksi`).
- **User Dashboard**: Personalized dashboard for users to manage their profiles, shops, and products.
- **Search & Filtering**: Easily find products, workers, and consultants based on categories.

## User Roles

The application supports multiple user roles, each with specific permissions:

- **Admin**: Full access to the system. Can manage all users, products, categories, and oversee transactions.
- **Farmer / Seller (Toko)**: Can create a shop profile, add/edit/delete their own products, and manage incoming orders. They can also offer services as a Worker or Consultant.
- **Buyer**: Can browse products, add items to their cart/wishlist, and complete transactions. Buyers can also hire farm workers and consultants.

## Project Structure

This project follows the standard Laravel MVC (Model-View-Controller) architecture. Here are the key directories:

- `app/Http/Controllers/`: Contains the core logic for handling requests (e.g., `HomeController`, `CartController`, `TokoController`, `AuthController`).
- `app/Models/`: Eloquent models representing the database tables (e.g., `Product`, `Toko`, `User`, `Cart`, `Order`).
- `routes/web.php`: Defines all web-accessible routes and applies necessary middleware (authentication, role checks).
- `resources/views/`: Contains the Blade template files for the frontend UI (e.g., dashboards, homepages, forms).
- `database/migrations/`: Database schema definitions for tables like `users`, `products`, `orders`, `tokos`, `tenaga_kerjas`, etc.
- `public/`: The entry point for the application. Contains compiled CSS/JS assets, images, and `index.php`.

## Routes & Endpoints

A summary of the main web routes in the application:

### Authentication
- `GET /login`, `POST /login` - User login
- `GET /register`, `POST /register` - User registration
- `POST /logout` - User logout

### Public Pages
- `GET /` - Homepage
- `GET /cari` - Search functionality
- `GET /produk/{slug}` - View specific product details
- `GET /Toko/{id}` - View specific shop profile
- `GET /Tenagakerja/view` - Browse available farm workers
- `GET /Ahlipakar/view` - Browse available agricultural experts/consultants

### User Dashboard (Requires Login)
- `GET /dashboard` - Main user dashboard
- `RESOURCE /dashboard/user` - User profile management
- `RESOURCE /dashboard/product` - Product management for farmers
- `RESOURCE /cart`, `RESOURCE /cartdetail` - Shopping cart management
- `RESOURCE /wishlist` - Wishlist management
- `GET /checkout`, `RESOURCE /transaksi` - Checkout and order processing

### Service Management (Role-Specific)
- `RESOURCE /TenagaKerja` - Farm worker management
- `RESOURCE /Konsultan` - Consultant management
- `RESOURCE /Toko` - Shop management

## Execution Guide

Follow these steps to run the project locally on your machine:

1. **Clone the repository** (if you haven't already):
   ```bash
   git clone <your-repository-url>
   cd HarvestHUB-Ecommerce
   ```

2. **Install PHP dependencies**:
   ```bash
   composer install
   ```

3. **Install NPM dependencies**:
   ```bash
   npm install
   npm run build # or npm run dev for development
   ```

4. **Environment Setup**:
   Copy the example `.env` file and generate an application key.
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

5. **Database Configuration**:
   Open the `.env` file and update your database credentials:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=your_database_name
   DB_USERNAME=your_database_user
   DB_PASSWORD=your_database_password
   ```

6. **Run Migrations & Seeders**:
   Migrate the database tables and (optionally) seed some initial data.
   ```bash
   php artisan migrate --seed
   ```

7. **Start the Development Server**:
   ```bash
   php artisan serve
   ```
   The application will be accessible at `http://127.0.0.1:8000`.

---
*Documentation generated for HarvestHUB-Ecommerce.*
