<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>

<h1>Food Ordering System</h1>

<p>This repository contains a <strong>Food Ordering System</strong> developed in PHP and MySQL. The project enables users to browse food categories, view food items, and place orders online. The admin panel allows managing orders, food items, and categories.</p>

<h2>Table of Contents</h2>
<ol>
    <li><a href="#features">Features</a></li>
    <li><a href="#installation">Installation</a></li>
    <li><a href="#database-setup">Database Setup</a>
        <ul>
            <li><a href="#database-creation">Database Creation</a></li>
            <li><a href="#tables">Tables</a></li>
            <li><a href="#database-connectivity">Database Connectivity</a></li>
        </ul>
    </li>
    <li><a href="#usage">Usage</a></li>
</ol>

<h2 id="features">1. Features</h2>
<ul>
    <li><strong>Browse Food Items</strong>: View items by category and make selections.</li>
    <li><strong>Order Management</strong>: Place and manage orders.</li>
    <li><strong>Admin Panel</strong>: Manage food items, categories, and order statuses.</li>
</ul>

<h2 id="installation">2. Installation</h2>

<h3>Prerequisites</h3>
<p>Ensure you have the following installed:</p>
<ul>
    <li>PHP (version 7.0 or higher)</li>
    <li>MySQL (as a database)</li>
    <li>Apache Server (use XAMPP or WAMP for an easy setup)</li>
    <li>Git (for cloning the repository)</li>
</ul>

<h3>Steps</h3>
<ol>
    <li><strong>Clone the Repository</strong>:
        <pre>git clone https://github.com/rachanayadavv/new_foodorder.git</pre>
    </li>
    <li><strong>Move Project to XAMPP Directory (For XAMPP Users)</strong>:
        <ul>
            <li>After cloning, copy the <code>new_foodorder</code> folder.</li>
            <li>Go to <code>C:\xampp\htdocs</code> and paste the folder here.</li>
            <li>Your project path should now be: <code>C:\xampp\htdocs\new_foodorder</code>.</li>
        </ul>
    </li>
    <li><strong>Start Apache and MySQL Services</strong>:
        <p>Open the XAMPP control panel and start <strong>Apache</strong> and <strong>MySQL</strong>.</p>
    </li>
    <li><strong>Database Setup</strong>:
        <p>Follow the instructions in the <a href="#database-setup">Database Setup</a> section to set up the necessary tables.</p>
    </li>
</ol>

<h2 id="database-setup">3. Database Setup</h2>

<h3 id="database-creation">3.1. Database Creation</h3>
<p>Open <a href="http://localhost/phpmyadmin">phpMyAdmin</a> in your browser. Create a new database named <code>food-order</code>.</p>

<h3 id="tables">3.2. Tables</h3>
<p>Run the following SQL queries in phpMyAdmin to set up the necessary tables.</p>

<h4>1. <code>tbl_admin</code> (For Admin User Management)</h4>
<p>This table stores admin credentials.</p>
<pre>
CREATE TABLE tbl_admin (
    id INT AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(100) NOT NULL,
    username VARCHAR(50) NOT NULL,
    password VARCHAR(255) NOT NULL
);
</pre>

<h4>2. <code>tbl_category</code> (For Food Categories)</h4>
<p>This table stores different food categories.</p>
<pre>
CREATE TABLE tbl_category (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(100) NOT NULL,
    image_name VARCHAR(255),
    featured ENUM('Yes', 'No') DEFAULT 'No',
    active ENUM('Yes', 'No') DEFAULT 'Yes'
);
</pre>

<h4>3. <code>tbl_food</code> (For Food Items)</h4>
<p>This table stores details about each food item.</p>
<pre>
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
</pre>

<h4>4. <code>tbl_order</code> (For Customer Orders)</h4>
<p>This table stores order information.</p>
<pre>
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
</pre>

<h3 id="database-connectivity">3.3. Database Connectivity</h3>
<p>In the root directory of the project, locate the <code>config.php</code> file.</p>

<p>Open <code>config.php</code> and set your database connection details as shown below:</p>
<pre>
<?php
// Start session
session_start();

// Create constants to store non-repeating values
define('SITEURL', 'http://localhost/food-order/');
define('LOCALHOST', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'food-order');
$conn = mysqli_connect(LOCALHOST, DB_USERNAME, DB_PASSWORD, DB_NAME, 3307) or die("Connection failed: " . mysqli_connect_error());
$db_select = mysqli_select_db($conn, DB_NAME) or die(mysqli_error());
?>
</pre>

<p>Save the <code>config.php</code> file and ensure the project can connect to your database.</p>

<h2 id="usage">4. Usage</h2>

<h3>Access the Application</h3>
<ol>
    <li>Open your browser and go to <a href="http://localhost/new_foodorder">http://localhost/new_foodorder</a> to access the main application.</li>
    <li>Use the navigation to explore categories, view food items, and place orders.</li>
</ol>

<h3>Admin Panel</h3>
<ol>
    <li>To access the admin panel, go to <a href="http://localhost/new_foodorder/admin">http://localhost/new_foodorder/admin</a>.</li>
    <li>Log in with the admin credentials (add default credentials to the <code>tbl_admin</code> table in phpMyAdmin if needed).</li>
    <li>Admins can manage food items, categories, and orders through this interface.</li>
</ol>

</body>
</html>
