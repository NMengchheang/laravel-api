1.  
### php artisan make:migration create_flights_table [Run to create table named flight]
### php artisan make:migration rename_column_name_to_title_categories_table --table=categories

2.  + "Model" that is used to interact with that table.
    + Eloquent models allow you to insert, update, and delete records from the table as well.
### php artisan make:model Flight [Run to create Model named Flight]
3.  + A controller may have any number of public methods which will respond to incoming HTTP requests
### php artisan make:controller FlightControler

1. Undo the Migration
To roll back the migration: 
### run : php artisan migrate:rollback

# run : php artisan migrate:fresh

=========== *How to Delete file Migrations, Controllers, Models* ===========
Step 1: Create the Custom Artisan Command
### run : php artisan make:command UninstallResource
This will generate a command file at app/Console/Commands/UninstallResource.php.

Step 2: Implement the Logic to Delete Files
You can take a look to views code that I configured.

Step 3: Register the Command
Make sure your custom command is registered in app/Console/Kernel.php.
You can take a look to views code that I configured.

Step 4: Clear Cached Configurations.
Run the following commands to clear and refresh Laravel's cache:
### run : 
# 1. php artisan config:clear
# 2. php artisan cache:clear
# 3. php artisan optimize:clear
# 4. php artisan list // Check if the uninstall:resource command is listed when you run:

*** Finally we use this command to delete Migrations, Controllers, Models.
Ex : use [Item] form instance name of Migrations, Controllers, Models.
### php artisan uninstall:resource Item
=========== ** ===========

1. Relationships Between Tables
ER Diagram Overview
- Users or Customers (1) — (M) Orders: A customer can have multiple orders.
- Orders (1) — (M) Order_Items: An order can have multiple items.
- Order_Items (M) — (1) Products: An item references one product.


# Kickstart analysis table

# ================================
1. Products Table : For storing details about each product.
- id (Integer (Primary Key))
- name (String)
- description (Text (Nullable))
- price (Decimal(10, 2))
- stock (Integer)
- category_id (Integer Nullable -> another)
- color VARCHAR(100) NULL
- accessories TEXT NULL
- created_at (Timestamp)
- updated_at (Timestamp)
- FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE SET NULL
# ================================
2. Categories Table : For organizing products into categories.
- id (Integer (Primary Key))
- name (String)
- description (Text (Nullable))
- created_at (Timestamp)
- updated_at (Timestamp)

# ================================
3. Orders Table : For tracking customer orders.
- id (Integer (Primary Key))
- user_id Integer (Foreign Key)
- total_price (Decimal(10, 2))
- status ENUM('pending', 'processing', 'shipped', 'delivered', 'cancelled', 'refunded') NOT NULL DEFAULT 'pending',
- created_at (Timestamp)
- updated_at (Timestamp)
- FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE

# ================================
4. Order_Items Table : For linking orders with the products purchased. {Connects orders to the products purchased.}
- id (Integer (Primary Key))
- order_id (Integer (Foreign Key))
- product_id (Integer (Foreign Key))
- quantity (Integer)
- price (Decimal(10, 2))
- created_at (Timestamp)
- updated_at (Timestamp)
# Database Schema
  * ER Diagram : Orders (1) ─── (M) OrderItems (M) ─── (1) Products

# ================================
5. Suppliers Table ; For managing supplier information.
- id (Integer (Primary Key))
- name (String)
- contact_info (String)
- address (Text (Nullable))
- created_at (Timestamp)
- updated_at (Timestamp)

# ================================
6. Inventory_Logs Table : For tracking inventory changes.
- id (Integer (Primary Key))
- product_id (Interger (Foreign Key))
- change_type (String)
- quantity_change (Integer)
- description (Text (Nullable))
- created_ate (Timestamp)
# ================================
7. User Table : For managing admin and employee accounts for the dashboard.
- id (Integer (Primary Key))
- name (String)
- email (String)
- email_verified_at (timestamp)
- password (String)
- remember_token (varchar)
- role (enum)
- status (enum)
- phone (varchar)
- address (text)
- created_at (Timestamp)
- updated_at (Timestamp)
# ================================
8. Cart Items Table (Temporary storage of cart items before checkout)
- id INT PRIMARY KEY AUTO_INCREMENT,
- user_id INT NOT NULL,
- product_id INT NOT NULL,
- quantity INT NOT NULL CHECK (quantity > 0),
- created_at (Timestamp)
- updated_at (Timestamp)
- FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
- FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
# ================================
*** => Link analysis table <= ***
# https://chatgpt.com/share/67a50bbd-3e24-8001-b4d2-ff04d1a2e452


















# https://chatgpt.com/c/678dcdf6-cc24-8001-9f99-e1bae6b79e8c (analysis table)

- Add this in AuthenticatedSessionController Auth controller to see local.INFO: User role: [take a look at (laravel.log​​) file]
# Log::info('User role:', ['role' => $request->user()->role]);
