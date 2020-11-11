## Booj Book Task Information

		Compose a site using the Laravel or Vue framework that allows the user to create a list of books they would like to read. 

		
		Users should be able to perform the following actions:

			- Connect to a publically available API

			- Create Postman collection and Vue app OR Laravel App

			- Add or remove items from the list

			- Change the order of the items in the list

			- Sort the list of items

			- Display a detail page with at least 3 points of data to display

			- Include unit tests


## Installing

- Clone repository

- run `composer install`

- Create mysql database & user with

```

CREATE USER 'someone'@'localhost' IDENTIFIED BY 'someone';

CREATE DATABASE `boojbooks`;

GRANT ALL PRIVILEGES ON boojbooks.* TO 'someone'@'localhost';

```

- Remove `.example` from `.env.example`

- Add the username and database to your `.env` file

- Add your google api key (Google Books API privilege) to `.env`

```

DB_DATABASE=boojbooks

DB_USERNAME=someone

DB_PASSWORD=

```
- run `php artisan migrate --seed`
	- Note the `--seed` flag.
  

## PHPUnit Test

- run PHPUnit with `./vendor/bin/phpunit`

  
## Unit Test Screenshot 

![php artisan migrate --seed && phpunit](https://i.gyazo.com/5ea7d39788f61d2e692d74a1c13b3836.png)