# Forked Version for Personal Purposes
This forked version of AIS is for personal use only, new features will be added but will not reflect on the original repository.

### Install
#### How to use this system

1. From here download the .zip file, extract it, and open the folder
2. Move all files from the unzipped folder to your webserver (if using xampp: it is on htdocs)
3. create a folder called `uploads`
`If you are using Linux, please set the chmod to 777 of uploads folder`
4. Do not start the webserver, proceed to Setup

#### Setup

1. on your mysql/mariadb database server, create a database
2. edit the `config.php` from your webserver and edit the following:
```php
/* Database credentials. Assuming you are running MySQL
server with default setting (user 'root' with no password) */
define('DB_SERVER', "insert db server/ip");
define('DB_USERNAME', "insert username");
define('DB_PASSWORD', "insert password");
define('DB_NAME', "insert your db name you created earlier");
define('DB_PORT', 3306); # edit the 3306 to the specific db server port
```
5. Start your webserver

##### Default Login (please do this so that you can add users)
Username: superadmin

Password: superadmin
