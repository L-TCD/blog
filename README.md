# Blog

[![Codacy Badge](https://api.codacy.com/project/badge/Grade/6ea5239ec8b24571952db428311e5079)](https://app.codacy.com/gh/L-TCD/blog?utm_source=github.com&utm_medium=referral&utm_content=L-TCD/blog&utm_campaign=Badge_Grade_Settings)

[Online example](https://blog.coissard.dev)  

This blog in PHP without framework or CMS is one of the projects of the "Application Developer - PHP / Symfony" training course on OpenClassrooms.

Developer : [Loïc](https://github.com/L-TCD)  
Supervisor/Teacher : [Charles](https://github.com/charlesen)

## SUMMARY
-   **[Technologies](#technologies)**
    -   [Server](#server)
    -   [Languages and libraries](#languages-and-libraries)

-   **[Installation](#installation)**
    -   [Configure environment variables](#configure-environment-variables)
	-   [Install Composer](#install-composer)
    -   [Create the database](#create-the-database)

---

## TECHNOLOGIES

### **Server**
You need a web server with PHP7 and MySQL.  
Versions used in this project:
-   PHP 7.4.21
-   MySQL 8.0.21

You also need an access to a SMTP server.

### **Languages and libraries**
This project is coded in **PHP7**, **HTML5**, **CSS3** and **JS**.  
Dependencies manager: **Composer**  
PHP packages, included via Composer:

-   altorouter/altorouter ^2.0.1 ([more info](https://github.com/dannyvankooten/AltoRouter.git))
-   fakerphp/faker ^1.15.0 ([more info](https://github.com/FakerPHP/Faker.git))
-   symfony/var-dumper ^v5.3.6 ([more info](https://github.com/symfony/var-dumper.git))
-   psr/container ^1.1.1 ([more info](https://github.com/php-fig/container.git))

CSS/JS libraries, included via CDN links:
-   Bootstrap ^5.0.2 ([more info](https://getbootstrap.com/docs/5.0/getting-started/introduction/))
-   Bootstrap-icons ^1.5.0 ([more info](https://icons.getbootstrap.com/))

---

## INSTALLATION

### **Configure environment variables**
1.  Open the *config.ini.example* file
2.  Replace the example values with your own values
3.  Rename the file *config.ini*

### **Install Composer**
1.  Install **Composer** by following ([the official instructions](https://getcomposer.org/download/)).
2.  Go to the project directory in your cmd:
```shell
$ cd some\directory
```
3.  Install dependencies with the following command:
```shell
$ composer install
```
Dependencies should be installed in your project (check _vendor_ directory).

### **Create the database**
1.  Create a new MySQL Database with the same name as in the config.ini file
2.  Create new tables :
```sql
CREATE TABLE `user` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `email` VARCHAR(255) NOT NULL,
  `username` VARCHAR(255) NOT NULL,
  `password` VARCHAR(255) NOT NULL,
  `admin` TINYINT(1) NOT NULL,
  `active` TINYINT(1) NOT NULL,
  `token` VARCHAR(255) NULL,
  `token_date` DATETIME NULL,
  PRIMARY KEY (`id`)
);

CREATE TABLE `post` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `title` VARCHAR(255) NOT NULL,
  `content` TEXT(10000) NOT NULL,
  `description` TEXT(3500) NOT NULL,
  `created_at` DATETIME NOT NULL,
  `update_at` DATETIME NULL,
  `author` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`id`)
);

CREATE TABLE `comment` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `content` TEXT(3500) NOT NULL,
  `created_at` DATETIME NOT NULL,
  `valid` TINYINT(1) NULL,
  `user_id` INT NOT NULL,
  `post_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT FK_comment_user FOREIGN KEY (user_id) REFERENCES user(id),
  CONSTRAINT FK_comment_post FOREIGN KEY (post_id) REFERENCES post(id)
);
```
3.  Install demo datas with the following command:
```shell
$ php commands/fill.php
```
This command create an account admin (username:"admin", password:"admin") and 9 account visitor with (password:"visitor").

### **Start the server and open public/index.php**
1.  You can start the web server
```shell
$ php -S localhost:8000 -t public
```
2.  Open it in your favorite browser: http://localhost:8000/