<b>Food Ordering System</b>
    This repository contains a Food Ordering System developed in PHP and MySQL. The project enables users to browse food categories, view food items, and place orders online. The admin panel allows managing orders, food items, and categories.

Table of Contents
    1.Features
    2.Installation
    3.Database Setup
     3.1.Database Creation
     3.2.Tables
     3.3.Database Connectivity
    4.Usage
   
1.Features
    - Browse Food Items: View items by category and make selections.
    - Order Management: Place and manage orders.
    - Admin Panel: Manage food items, categories, and order statuses.

2.Installation
    Prerequisites
    Ensure you have the following installed:

    - PHP (version 7.0 or higher)
    - MySQL (as a database)
    - Apache Server (use XAMPP or WAMP for an easy setup)
    - Git (for cloning the repository)

Steps
1.Clone the Repository:

   - git clone https://github.com/rachanayadavv/new_foodorder.git
2.Move Project to XAMPP Directory (For XAMPP Users):

   - After cloning, copy the new_foodorder folder.
   - Go to C:\xampp\htdocs and paste the folder here.
   - Your project path should now be: C:\xampp\htdocs\new_foodorder.
3.Start Apache and MySQL Services:

    Open the XAMPP control panel and start Apache and MySQL.
4.Database Setup:Follow the instructions in the Database Setup section to set up the necessary tables.

3.Database Setup
    3.1.Database Creation
        Open phpMyAdmin in your browser: http://localhost/phpmyadmin.
        Create a new database named food-order.
    3.2.Tables
        Run the following SQL queries in phpMyAdmin to set up the necessary tables.

        1. tbl_admin (For Admin User Management)
        This table stores admin credentials.

        CREATE TABLE tbl_admin (
            id INT AUTO_INCREMENT PRIMARY KEY,
            full_name VARCHAR(100) NOT NULL,
            username VARCHAR(50) NOT NULL,
            password VARCHAR(255) NOT NULL
        );
        2. tbl_category (For Food Categories)
        This table stores different food categories.

            CREATE TABLE tbl_category (
            id INT AUTO_INCREMENT PRIMARY KEY,
            title VARCHAR(100) NOT NULL,
            image_name VARCHAR(255),
            featured ENUM('Yes', 'No') DEFAULT 'No',
            active ENUM('Yes', 'No') DEFAULT 'Yes'
        );
        3. tbl_food (For Food Items)
        This table stores details about each food item.

            CREATE TABLE tbl_food (
            id INT AUTO_INCREMENT PRIMARY KEY,
            title VARCHAR(100) NOT NULL,
            description TEXT,
            price DECIMAL(10,2) NOT NULL,
            image_name VARCHAR(255),
            category_id INT,
            featured ENUM('Yes', 'No') DEFAULT 'No',
            active ENUM('Yes', 'No') DEFAULT 'Yes',
            FOREIGN KEY (category_id) REFERENCES tbl_category(id)
        );
        4. tbl_order (For Customer Orders)
        This table stores order information.

            CREATE TABLE tbl_order (
            id INT AUTO_INCREMENT PRIMARY KEY,
            food VARCHAR(100) NOT NULL,
            price DECIMAL(10,2) NOT NULL,
            qty INT NOT NULL,
            total DECIMAL(10,2) NOT NULL,
            order_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            status ENUM('Ordered', 'On Delivery', 'Delivered', 'Cancelled') DEFAULT 'Ordered',
            customer_name VARCHAR(100),
            customer_contact VARCHAR(15),
            customer_email VARCHAR(50),
            customer_address TEXT
        );
    3.3.Database Connectivity
    In the root directory of the project, locate the config.php file.

    Open config.php and set your database connection details as shown below:
        <?php
        //start session
        session_start();

        // Create constants to store non-repeating values
        define('SITEURL', 'http://localhost/food-order/');
        define('LOCALHOST', 'localhost');
        define('DB_USERNAME', 'root'); // Fixed a typo here, replaced '.' with ','
        define('DB_PASSWORD', '');
        define('DB_NAME', 'food-order'); // Added a missing semicolon here
        $conn = mysqli_connect(LOCALHOST, DB_USERNAME, DB_PASSWORD, DB_NAME, 3307) or die("Connection failed: " . mysqli_connect_error());
        $db_select = mysqli_select_db($conn, DB_NAME) or die(mysqli_error()); // Used constants without quotes


        Save the config.php file and ensure the project can connect to your database.

4.Usage
    Access the Application
1.Open your browser and go to http://localhost/new_foodorder to access the main application.
2.Use the navigation to explore categories, view food items, and place orders.
    Admin Panel
1.To access the admin panel, go to http://localhost/new_foodorder/admin.
2.Log in with the admin credentials (add default credentials 3.to the tbl_admin table in phpMyAdmin if needed).
Admins can manage food items, categories, and orders through this interface.
