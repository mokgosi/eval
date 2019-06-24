# eval

[GitHub](http://github.com)


## Installation Instructions

The following instructions assumes that you are familiar with the necessary technologies required to carry out installation and that you have them already insalled in your machine.

Based on: 
* php 7.3.3
* Laravel 5.8.15
* mysql/mariadb 10.1.38-MariaDB
* laravel/lumen-framework 5.8


**NOTE:** For this API to work, you must have created a database and actioned files/question2.sql to create tables and run files/question3.php to import fixture data. I suggest you create a quick project folder in your project folder and put these files and execute them from in there.


### Clone the repository:
```

$ git clone git@github.com:mokgosi/eval.git

```

### Install dependencies
```

$ composer update

```

### Create Database  (ignore - exists already from question 2)

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

**Test your API**

Browse to http://localhost:8000/users


### Usage

All requests are of Content-type: application/json header.

Use your preferred tool example: [Postman](https://www.getpostman.com/) to perfom the following example requests:


**Add User**

End-point: http://localhost:8000/users

Body:


```
{
	"id_number": "1114567890123", "first_names": "Name", "last_name": "Surname",
	"profile_types": {
		"record_number": "333",
		"msisdn": "0720112966",
		"network": "Vodacom",
		"points": "4",
		"card_number": "4567233213214444",
		"gender": "M"
	}
}
```

**Update User**

End-point: http://localhost:8000/users/7

Body:


```
{
	"id_number": "7900000000000", "first_names": "Name1", "last_name": "Surname1",
	"profile_types": {
		"record_number": "333",
		"msisdn": "0720112966",
		"network": "Vodacom",
		"points": "67",
		"card_number": "4567233213214446",
		"gender": "F"
	}
}
```

**Search User - by id_number**

End-point: http://localhost:8000/users/7900000000000


**Delete User - by id_number**

End-point: http://localhost:8000/users/7900000000000

