# E-commerce System with Order Processing and Inventory Management

## Overview

This project is an E-commerce System built using Laravel, designed to manage product catalogs, process orders, handle inventory, and integrate with payment gateways. The system leverages advanced Laravel concepts such as service providers, repository pattern, events and listeners, job queues, and comprehensive testing.

## Features

### 1. Product Management Module

- **CRUD Operations**: Create, read, update, and delete products.
- **Repository Pattern**: Ensures loose coupling between product logic and database interaction.
- **Categories and Tags**: Products can be associated with multiple categories and tags.

### 2. Order Processing Module

- **Order Placement**: Users can place orders for products, selecting quantities from available stock.
- **Inventory Management**: Automatically reduces inventory count upon order placement.
- **Validation**: Ensures requested product quantity does not exceed available stock.
- **Notifications**: Uses Laravel Events and Listeners to send email notifications when an order is placed.
- **Asynchronous Processing**: Processes large orders asynchronously.

### 3. Inventory Management Module

- **Inventory Tracking**: Admin users can track and update product inventory.
- **Restocking**: Admin users can restock products.
- **Threshold Notifications**: Notifies admin users when inventory falls below a certain threshold.
- **Service Providers**: Handles complex inventory calculations.
- **Inventory Logs**: Tracks adjustments such as restocks and sales.

### 4. Payment Gateway Integration

- **Payment Processing**: Integrates with a payment gateway to handle payments.
- **Validation**: Validates card or payment details before confirming the order.
- **Dependency Injection**: Implements the payment system as a replaceable service.

### 5. Order and Product Discounts

- **Discount System**: Applies percentage-based or fixed amount discounts to orders or specific products.
- **Middleware**: Uses custom middleware to dynamically calculate and apply discounts at checkout.

### 6. API Development

- **REST API**: Exposes endpoints for product listings, order placement, and inventory management.
- **Authentication**: Protects the API with Laravel authentication.
- **Rate Limiting**: Implements API rate limiting to prevent abuse.

### 7. Testing and Code Quality

- **Unit and Feature Tests**: Uses PestPHP to ensure core functionality.
- **Coverage**: Tests product CRUD operations, inventory management, order processing, and payment gateway interactions.
- **SOLID Principles**: Ensures code follows SOLID principles and best practices.

### 8. Deployment Considerations

- **CI/CD Pipeline**: Automates testing and deployment.
- **Docker Containers**: Prepares Docker containers for easy deployment across different environments.

### Test Data Generation (Factories and Seeders)

- **Data Generators**: Implements factories and seeders for generating test data.
- **Realistic Scenarios**: Ensures realistic scenarios are covered during development and testing.
- **Baseline Data**: Populates the database with a baseline of test data for products and orders.

## Installation

### Prerequisites

- PHP
- Composer
- Node.js
- npm

### Steps

1. **Clone the repository**:

   ```bash
   git clone https://github.com/your-username/ecommerce-app.git
   cd ecommerce-app
   ```

2. **Set up environment variables**:

   ```bash
   cp .env.example .env
   ```

3. **Install PHP dependencies**:

   ```bash
   composer install
   ```

4. **Install npm dependencies**:

   ```bash
   npm install
   ```

5. **Run database migrations and seeders**:

   ```bash
   php artisan migrate --seed
   ```

6. **Build assets**:
   ```bash
   npm run dev
   ```

## Usage

### Running the Application Locally

1. **Start the Vite development server**:

   ```bash
   npm run dev
   ```

2. **Start the Laravel development server**:
   ```bash
   php -S localhost:8000 -t public
   ```

### Running the Application in Docker

1. **Build and run Docker containers**:

   ```bash
   docker-compose up --build
   ```

2. **Run database migrations and seeders**:
   ```bash
   docker-compose exec app php artisan migrate --seed
   ```

### Access the Application

- The application will be accessible at `http://localhost:8000` when running locally.
- The application will be accessible at `http://localhost:9000` when running in Docker.

### Running Tests

- To run tests, use the following command:
  ```bash
  ./vendor/bin/pest
  ```

## API Endpoints

### Products

- **GET /api/products**: Retrieve product listings with pagination, filtering, and searching.
- **POST /api/products**: Create a new product (admin only).
- **PUT /api/products/{id}**: Update an existing product (admin only).
- **DELETE /api/products/{id}**: Delete a product (admin only).

### Orders

- **POST /api/orders**: Place an order.

### Inventory

- **GET /api/inventory**: Retrieve inventory details (admin only).
- **POST /api/inventory**: Update inventory (admin only).

## Contributing

Contributions are welcome! Please fork the repository and submit a pull request for review.

## License

This project is licensed under the MIT License.
