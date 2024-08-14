# Inventory Management System

A simple inventory management system designed to manage product categories, products, and orders. This system includes features for business owners to create and manage product listings, and for users to place orders while updating product quantities.

## Features

- **User Authentication:** Secure login and registration for both business owners and users.
- **Product Management:** Business owners can create, update, and delete products. Users can view available products.
- **Category Management:** Manage product categories, which can be associated with products.
- **Order Placement:** Users can place orders for products, which updates product stock quantities.

## Technologies Used

- **Backend:** Laravel (PHP Framework)
- **Database:** MySQL
- **Authentication:** Laravel Sanctum

**Installation**

Clone the repository to your local machine using Git (or download the zip file and extract it):

    git clone https://github.com/esru13/Inventory-System-

Navigate to the project directory:

    cd Inventory-System-

Install PHP dependencies using Composer:

    composer install

Copy the .env.example file to create a .env file:

    cp .env.example .env

Generate a new application key:

    php artisan key:generate

Configure your database settings in the .env file:

##
    DB_CONNECTION=mysql

    DB_HOST=127.0.0.1

    DB_PORT=3306

    DB_DATABASE=[your_database_name]

    DB_USERNAME=[your_database_username]

    DB_PASSWORD=[your_database_password]
##

Migrate the database:

    php artisan migrate
    

Running the Application

To start the development server, run the following command:

    php artisan serve
##