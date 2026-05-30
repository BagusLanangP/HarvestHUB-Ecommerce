# Changelog

All notable changes to this project will be documented in this file.

## [Unreleased]

### Added
- **Image Management System (Intervention Image)**: Integrated `intervention/image` (v4) to automatically process, crop, and resize uploaded product photos to an 800x800px resolution.
- **Default Image Fallback Logic**: Created an Eloquent Accessor `getImageUrlAttribute()` in the `Product` model to serve a default placeholder image (`default-product.png`) when a product lacks a photo.
- **Storage Cleanup**: Added logic in `DashboardProductController` to delete old images from the `public` storage disk when a product is updated or destroyed.
- **Product Image Tests (`ProductImageUploadTest.php`)**: Added feature tests to ensure the image upload, processing, and storage logic functions correctly without integrity constraint issues.
- **Dynamic Password Hashing in UserSeeder**: Optimized `UserSeeder.php` by defining seeded user passwords as plain-text `'password'` and hashing them dynamically using the `bcrypt()` helper during execution.
- **Authentication Feature Tests (AuthTest.php)**: Implemented automated integration tests verifying both Registration and Login scenarios, including success and failure cases with correct validation checks and database assertions.
- **UserFactory Enhancements**: Extended `UserFactory.php` with default `'phone'` configuration to fulfill structural integrity constraints during testing.
