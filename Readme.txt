Requirement to run the application

PHP >= 7.1.3
OpenSSL PHP Extension
PDO PHP Extension
Mbstring PHP Extension
Mysql >= 5.7
Composer (Dependency Manager for PHP)
Postman (To test your endpoints)

Step to Run APP

1. clone the project
2. copy and rename .env.example to .env and input db name & pass 
Example:

DB_PORT=3306
DB_DATABASE=test-api
DB_USERNAME=root
DB_PASSWORD=pass


3. Update composer and replace auth.php with this code
file path : tizaara\tizaara-api\vendor\laravel\lumen-framework\config\auth.php
//-------------
<?php

return [
    'defaults' => [
        'guard' => 'api',
        'passwords' => 'users',
    ],

    'guards' => [
        'api' => [
            'driver' => 'jwt',
            'provider' => 'users',
        ],
    ],

    'providers' => [
        'users' => [
            'driver' => 'eloquent',
            'model' => \App\User::class
        ]
    ]
];

//------- You need to edit this file manually for git ignore

4. Migrate your database with this command
  php artisan migrate

5. To run project locally  
  php -S localhost:8080 -t public

// 
//to crate users table
php artisan make:migration create_users_table

// create user seeder
php artisan make:seeder UserSeeder


//To Create migration
 php artisan migrate

// seed user data
 php artisan db:seed --class=UserSeeder


// to trancate DB
php artisan db:wipe


------------------------------------------
// CORS config for allowing  cross-domain communication from the browser

1=> composer require nordsoftware/lumen-cors
2=> Copy cord.php from nordsoftware/lumen-cors/config into the root/config directory . 
3=> Add the following lines to the bootstrap/app.php file:
  $app->register('Nord\Lumen\Cors\CorsServiceProvider');
  $app->middleware([
	.....
	'Nord\Lumen\Cors\CorsMiddleware',
]);

If any error need to composer update

-----------------------------------------
// Common Endppoind should use
Get all brands-     GET =>   /brands
Create a brands -   POST =>  /brands

Create a brands -    POST=>  /brands/search

Get one brands -      GET =>  /brands/1
Edit a brands -      POST =>  /rands/1
Delete a brands - DELETE =>   /brands/1


