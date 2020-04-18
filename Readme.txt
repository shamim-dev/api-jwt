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