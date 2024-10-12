# MetaCart

## Introduction

Welcome to the MetaCart, a full stack web application developed using Laravel 11 and Vue. This application allows users to manage products and orders efficiently. Users can create, read, update, and delete products and orders through a simple and intuitive interface. Additionally, the application supports real-time updates and integrates authentication and authorization for secure access.


## Features

- **CRUD Operations:** Create, read, update, and delete products and orders.
- **Real-time Updates:** Automatic updates of request data in the table.
- **Authentication and Authorization:** Secure access to the application.
- **API Endpoints:** Well-defined endpoints for managing requests.
- **Validation and Error Handling:** Robust request validation and error management.
- **Responsive Design:** Usable on various devices with a responsive frontend.

## Included in the Project

- Full source code of the application.
- MySQL database dump.
- Screenshots.

## Setup Instructions

### Prerequisites

Ensure you have the following installed on your machine:

- PHP 8.1 or higher
- Composer
- Node.js and npm
- MySQL

### Cloning the Repository

1. Clone the repository to your local machine:
    ```sh
    git clone https://github.com/lankeshhalangoda/Parallax-E-Commerce-Demo.git
    cd parallax-e-commerce-demo
    ```

### Backend Setup

1. Install PHP dependencies:
    ```sh
    composer install
    ```

2. Create a copy of the `.env.example` file and rename it to `.env`:
    ```sh
    cp .env.example .env
    ```

3. Update the `.env` file with your database configuration:
    ```sh
    DB_DATABASE=parallax_ase
    DB_USERNAME=root
    DB_PASSWORD=your_password
    ```

4. Generate an application key:
    ```sh
    php artisan key:generate
    ```

5. Run database migrations and seeders:
    ```sh
    php artisan migrate --seed
    ```

### Frontend Setup

1. Install Node.js dependencies:
    ```sh
    npm install
    ```

2. Build the frontend assets:
    ```sh
    npm run dev
    ```

### Running the Application

1. Start the Laravel development server:
    ```sh
    php artisan serve
    ```

2. Open your browser and navigate to `http://localhost:8000`.


## Additional Information

- **Database Dump:** Included in the `database` directory.
- **Screenshots Collection:** Included in the `screenshots` directory.

