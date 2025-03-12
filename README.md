Follow these steps to set up and run the MASKICE Laravel project on your local machine.

Prerequisites

Ensure you have the following installed on your system:

PHP (>= 8.0 recommended)

Composer (PHP dependency manager)

MySQL or SQLite (Database system)

Node.js & npm (For frontend assets, if applicable)

Git (Version control)

Web Server: Laravel's built-in server, Apache (XAMPP), or Nginx



Step 1: Clone the Project

Open a terminal and run:

Clone the repository from GitHub.

Navigate to the project directory.



Step 2: Install Dependencies

Run composer install to install Laravel dependencies.

If frontend dependencies are required, run npm install.



Step 3: Set Up the Environment File

Copy the example environment file by renaming .env.example to .env.

Open .env and configure database settings:

Set DB_CONNECTION to mysql.

Define DB_HOST, DB_PORT, DB_DATABASE, DB_USERNAME, and DB_PASSWORD as per your database setup.



Step 4: Generate Application Key

Run php artisan key:generate to set the APP_KEY in your .env file.



Step 5: Run Database Migrations

If your Laravel project uses a database, set up the tables by running php artisan migrate. If you need test data, run php artisan db:seed.



Step 6: Start the Development Server

To serve the application, run php artisan serve. Open http://127.0.0.1:8000 in your browser.



Step 7: (Optional) Use XAMPP Instead of php artisan serve

Move the project to C:\xampp\htdocs\MASKICE.

Ensure mod_rewrite is enabled in C:\xampp\apache\conf\httpd.conf.

Add a virtual host in C:\xampp\apache\conf\extra\httpd-vhosts.conf.

Edit the hosts file (C:\Windows\System32\drivers\etc\hosts) and add 127.0.0.1 maskice.local.

Restart Apache in XAMPP.

Open http://maskice.local in your browser.



Step 8: Running Additional Commands (If Needed)

If your project includes queue workers, run php artisan queue:work.

If the project uses caching, run php artisan config:cache.

If using frontend assets, run npm run dev.
