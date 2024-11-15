# Backend Test

This is a Laravel, web-based project, dedicated to PT. Global Inovasi Gemilang, this project should serve as my final results for the backend test.

Please refer to [Postman Collection](https://blue-flare-865064.postman.co/workspace/Team-Workspace~22f02c25-ec65-41d4-88d0-063c448472ec/collection/21527756-dbfddcfa-217b-4c37-87b7-a53f1deda5a7?action=share&creator=21527756) for the complete API documentation.

Installation:

Clone from Github

    git clone https://github.com/brstreet2/backend-test.git

After you're done cloning, navigate to the project root directory, and install the required dependencies and packages.

Note: You must be using PHP 8.3 or higher

    composer install

Once you've installed the necessary dependencies and packages, please set your JWT_SECRET by using the command:

    php artisan:secret

It will automatically generate a secret key for JWT and generate default JWT hashing algorithm in your env, so by now your ENV should look like this:

    APP_NAME=Laravel
    APP_ENV=local
    APP_KEY=base64:QbRdGQMRiqRZKGilw7pgoDm9lx8SSE+3ugW+oFIUr34=
    APP_DEBUG=true
    APP_TIMEZONE=UTC
    APP_URL=http://localhost

    APP_LOCALE=en
    APP_FALLBACK_LOCALE=en
    APP_FAKER_LOCALE=en_US

    APP_MAINTENANCE_DRIVER=file
    # APP_MAINTENANCE_STORE=database

    PHP_CLI_SERVER_WORKERS=4

    BCRYPT_ROUNDS=12

    LOG_CHANNEL=stack
    LOG_STACK=single
    LOG_DEPRECATIONS_CHANNEL=null
    LOG_LEVEL=debug

    DB_CONNECTION=pgsql
    DB_HOST=127.0.0.1
    DB_PORT=5432
    DB_DATABASE=crm_company
    DB_USERNAME=postgres
    DB_PASSWORD=

    SESSION_DRIVER=database
    SESSION_LIFETIME=120
    SESSION_ENCRYPT=false
    SESSION_PATH=/
    SESSION_DOMAIN=null

    BROADCAST_CONNECTION=log
    FILESYSTEM_DISK=local
    QUEUE_CONNECTION=database

    CACHE_STORE=database
    CACHE_PREFIX=

    MEMCACHED_HOST=127.0.0.1

    REDIS_CLIENT=phpredis
    REDIS_HOST=127.0.0.1
    REDIS_PASSWORD=null
    REDIS_PORT=6379

    MAIL_MAILER=log
    MAIL_HOST=127.0.0.1
    MAIL_PORT=2525
    MAIL_USERNAME=null
    MAIL_PASSWORD=null
    MAIL_ENCRYPTION=null
    MAIL_FROM_ADDRESS="hello@example.com"
    MAIL_FROM_NAME="${APP_NAME}"

    AWS_ACCESS_KEY_ID=
    AWS_SECRET_ACCESS_KEY=
    AWS_DEFAULT_REGION=us-east-1
    AWS_BUCKET=
    AWS_USE_PATH_STYLE_ENDPOINT=false

    VITE_APP_NAME="${APP_NAME}"

    JWT_SECRET=df8bdd0cc4e84e694f1e369011775340c28e3cfebbdff1ea63e429eab42423ff583c316412d14d4a4486e5cf4c9ec3b20b93b6b2dc47017fe5c2d626e6233423d8ac7d9ce7359adbcf5f361a4383ee582a7567345e09ebab19cd9b4468d6c97bac2dd789a5cc322a9eece0f526ff13535fb2896079de98c77e5e188b8921bfc09d8608d08b054849248cba66f951b1deb06613eae173a561f6f72754e55339e8f7ff9162dc580d4ceed30fd6cb6f4c809785258f4e0f66655856b66a3f479123e3d973817a5fb9c2eefc52b5db672b70505bd25f1472ef0c99fb4e674ae111ac0058f2e90a005a8eed5f3cf414c12c963a57e30b556c6a8200b6487404e851f2

    JWT_ALGO=HS256

    JWT_REFRESH_TTL=43200

And last, please set and do your own database connection, in this project, I am using PostgreSQL.

## Database Migrations & Seeder

Run the following command to create your tables on the database, and create a super admin user.

    php artisan migrate
    php artisan db:seed

This is the email & password used to login as super admin

    email: super@admin.com
    password: Password123!

## Features

-   Role based system, with 3 roles available (super_admin, manager, employee).
-   Dynamic employees for companies.
-   Generate database tables using migration.
-   Generate a root admin data using seeder.

Checkout the [Postman Collection](https://blue-flare-865064.postman.co/workspace/Team-Workspace~22f02c25-ec65-41d4-88d0-063c448472ec/collection/21527756-dbfddcfa-217b-4c37-87b7-a53f1deda5a7?action=share&creator=21527756) for the complete API Docs.

## Third party library / packages

-   php-open-source-saver/jwt-auth ^2.7 : JWT library for Laravel / PHP.
