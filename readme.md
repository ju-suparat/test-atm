# Test Project For Excite Holidays
This project is only for simulates the logic of a cash dispensing Automatic Teller Machine (ATM).
## Installation

To get started, the following steps needs to be taken:

* Clone the repo ```git clone https://github.com/ju-suparat/test-atm.git```
* cd into project ```cd test-atm```
* Create a copy of .env file to fill out project configurations eg. database ```cp .env.example .env```
* Install dependencies ```composer install```
* Generate project's encryption key ```php artisan key:generate```
* Create an empty database for the project
* Update database information in ```.env``` file ```DB_HOST```, ```DB_PORT```, ```DB_DATABASE```, ```DB_USERNAME``` and ```DB_PASSWORD``` to match the credentials of database you just created.
* Migrate the database ```php artisan migrate```
* Seed the database(Optional) ```php artisan db:seed```
* Run ```php artisan serve```

You can now access to the project at http://127.0.0.1:8000 by default
