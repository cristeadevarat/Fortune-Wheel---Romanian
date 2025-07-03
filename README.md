# Fortune-Wheel---Romanian
A simple and interactive Fortune Wheel (Spin &amp; Win) web application. Built with HTML, CSS, and JavaScript for the frontend, and PHP for handling prize claim submissions to a database.

````markdown
# Spin & Win - Fortune Wheel

## Project Description
A simple and interactive Fortune Wheel (Spin & Win) web application. Built with HTML, CSS, and JavaScript for the frontend, and PHP for handling prize claim submissions to a database.

## Features
* Interactive spinning wheel with customizable prizes.
* Dynamic SVG rendering of the wheel and prize segments.
* Smooth animation for the spinning action.
* Modal pop-up to display the won prize.
* Form to collect winner's name and email.
* Backend (PHP) to save winner data to a MySQL database.
* Basic input validation and email uniqueness check on the backend.
* Responsive design for various screen sizes.

## Technologies Used
* **Frontend:**
    * HTML5
    * CSS3
    * JavaScript (ES6+)
    * SVG for wheel rendering
* **Backend:**
    * PHP
* **Database:**
    * MySQL (or MariaDB)

## Setup and Installation

### 1. Web Server
You need a local web server environment (e.g., XAMPP, WAMP, MAMP, or LAMP stack) with PHP and MySQL installed.

### 2. Database Setup

Create a database named `fortune_wheel` (or `spin_win_db` depending on which PHP file's configuration you use) and a table named `winners`.

**SQL Schema for `winners` table (for `save_winner.php`):**

```sql
CREATE DATABASE IF NOT EXISTS fortune_wheel;

USE fortune_wheel;

CREATE TABLE IF NOT EXISTS winners (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    prize VARCHAR(255) NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    ip_address VARCHAR(45)
);
````

**SQL Schema for `winners` table (for `view_winners.php`):**

```sql
CREATE DATABASE IF NOT EXISTS spin_win_db;

USE spin_win_db;

CREATE TABLE IF NOT EXISTS winners (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    prize VARCHAR(255) NOT NULL,
    timestamp DATETIME DEFAULT CURRENT_TIMESTAMP
);
```

**Note:** Ensure you use the correct database name and table schema consistent with the PHP script you intend to use. The `save_winner.php` provided uses `fortune_wheel` and `created_at` with an `ip_address` field, while `view_winners.php` uses `spin_win_db` and `timestamp` without `ip_address`. It's recommended to standardize these.

### 3\. Configure PHP Files

Open `save_winner.php` and `view_winners.php` and update the database connection details:

```php
// In save_winner.php:
$servername = "localhost";
$username = "your_db_username"; // Replace with your MySQL username
$password = "your_db_password"; // Replace with your MySQL password
$dbname = "fortune_wheel";      // Ensure this matches your created database name

// In view_winners.php:
$servername = "localhost";
$username = "root";             // Replace with your MySQL username
$password = "";                 // Replace with your MySQL password
$dbname = "spin_win_db";        // Ensure this matches your created database name
```

**Important:** For security reasons, avoid using 'root' with an empty password in production environments.

### 4\. Place Files on Server

Place `index.html`, `save_winner.php`, and `view_winners.php` (and any image files, if used) into your web server's document root (e.g., `htdocs` for XAMPP).

## Usage

1.  Start your Apache and MySQL services in your XAMPP/WAMP/MAMP control panel.
2.  Open your web browser and navigate to `http://localhost/your_project_folder/index.html`.
3.  Click the "ÎNVÂRTE ROATA" (Spin the Wheel) button to spin the wheel.
4.  If you win a prize, a modal will appear where you can enter your name and email to claim it.
5.  The winner's data will be saved to your MySQL database.

## Customization

  * **Prizes:** Edit the `prizes` array in `index.html` to change prize names and colors.
  * **Styling:** Modify the CSS within the `<style>` tags in `index.html` to change the appearance of the wheel and modal.
  * **Backend Logic:** Adjust `save_winner.php` or `view_winners.php` to modify how winner data is handled or displayed.

## Contributing

Feel free to fork the repository, make improvements, and submit pull requests.

## License

[Choose a license, e.g., MIT License, and link to its text.]

```
```
