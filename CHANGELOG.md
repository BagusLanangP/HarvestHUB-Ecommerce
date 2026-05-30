# Changelog

All notable changes to this project will be documented in this file.

## [Unreleased]

### Added
- **Dynamic Password Hashing in UserSeeder**: Optimized `UserSeeder.php` by defining seeded user passwords as plain-text `'password'` and hashing them dynamically using the `bcrypt()` helper during execution.
- **Authentication Feature Tests (AuthTest.php)**: Implemented automated integration tests verifying both Registration and Login scenarios, including success and failure cases with correct validation checks and database assertions.
- **UserFactory Enhancements**: Extended `UserFactory.php` with default `'phone'` configuration to fulfill structural integrity constraints during testing.
