# A Better Community Database

*A Better Community Database for non-profit organizations. *

ABCD revolutionizes data management for non-profits with an easy-to-use, flexible approach to collaborative learning. And with its powerful survey creation and ad-hoc report generation features, our software for non-profits will help you create significant insights quickly. ABCD is a smart choice for any NPO or social good collaborative looking for a better way to do data.

This repository is dedicated to the development of ABCD v3 which is based off of [Laravel](https://laravel.com/) and [Vue.js](https://vuejs.org/).


If you would love to try ABCD, checkout the live version at [betterdatabase.ca](https://betterdatabase.ca).

## Configuration

After cloning this repository, follow the steps below. If you're using the command line, make sure that you `cd` into the cloned version of this repository. 

### 1. Create .env file

 `$ mv .env.example .env` or simply rename **.env.example** to **.env**.

### 2. Generate Application Key

Run `$ php artisan key:generate` in your command line. 

This should automatically set a value for the `APP_KEY` environment variable in the .env file that you created in **Step 1**.

### 3. Configure database

Still in the **.env file**, set the following variables according to your local environment:

```
DB_CONNECTION=
DB_HOST=
DB_PORT=
DB_DATABASE=
DB_USERNAME=
DB_PASSWORD=
```

Here's an example:

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=abcd
DB_USERNAME=root
DB_PASSWORD=
```

### 4. Install dependencies
In your command line, assuming that you're the cloned repository's directory, run:

`npm install && composer install`

And that's about it!
