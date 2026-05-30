# Changelog

All notable changes to this project will be documented in this file.

## [Unreleased]

### Added
- **Transaction History & Status Workflow**: Implemented an order and transaction tracking page (`/transaksi`) where customers can view their purchase history, order status, total price, and mark transactions as completed.
- **Rating & Review System**: Added a comprehensive rating and review system. Users can submit star ratings (1-5) and text comments for purchased products only after a transaction is marked as 'Completed'.
- **Average Ratings and Reviews Display**: Integrated product rating calculations and displays. The product index pages now dynamically display the average star rating and show all customer reviews.
- **Automated Tests (`TransactionTest.php` and `ReviewTest.php`)**: Developed full feature test suites checking:
  - Retrieval of user transaction history.
  - Verification that reviews can only be submitted for completed transactions.
  - Dynamic calculation of average product ratings.
- **Image Management System (Intervention Image)**: Integrated `intervention/image` (v4) to automatically process, crop, and resize uploaded product photos to an 800x800px resolution.
- **Default Image Fallback Logic**: Created an Eloquent Accessor `getImageUrlAttribute()` in the `Product` model to serve a default placeholder image (`default-product.png`) when a product lacks a photo.
- **Storage Cleanup**: Added logic in `DashboardProductController` to delete old images from the `public` storage disk when a product is updated or destroyed.
- **Product Image Tests (`ProductImageUploadTest.php`)**: Added feature tests to ensure the image upload, processing, and storage logic functions correctly without integrity constraint issues.
- **Dynamic Password Hashing in UserSeeder**: Optimized `UserSeeder.php` by defining seeded user passwords as plain-text `'password'` and hashing them dynamically using the `bcrypt()` helper during execution.
- **Authentication Feature Tests (AuthTest.php)**: Implemented automated integration tests verifying both Registration and Login scenarios, including success and failure cases with correct validation checks and database assertions.
- **UserFactory Enhancements**: Extended `UserFactory.php` with default `'phone'` configuration to fulfill structural integrity constraints during testing.
