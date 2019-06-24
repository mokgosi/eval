# eval

[GitHub](http://github.com)

## Installation Instructions

The following instructions assumes that you are familiar with the necessary technologies required to carry out installation and that you have them already insalled in your machine.

Based on: 
* php 7.3.3
* Laravel 5.8.15
* mysql/mariadb 10.1.38-MariaDB
* laravel/lumen-framework 5.8


### Clone the repository:
```

$ git clone git@github.com:mokgosi/eval.git

```

### Install dependencies
```

$ composer update

```

### Create Database

```

mysql -u root -p<password>
CREATE DATABASE dbname;

```

**Create .env**

```

$ cp .env.example .env

``` 

**Update .env file with database name and credentials and other info**

```

APP_NAME=App Name
APP_URL=http://localhost:8000

DB_DATABASE=dbname
DB_USERNAME=username
DB_PASSWORD=password

```

**Start your local server**

```

$ cd to-your-project-root
$ php -S localhost:8000 -t public

```

###Test your API##

Browse to http://localhost:8000/users


Use your preferred tool example: [Postman](https://www.getpostman.com/) to perfom the following requests




