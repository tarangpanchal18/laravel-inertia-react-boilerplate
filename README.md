# Laravel Core Admin Panel built in laravel 9
A complete ready to use admin panel built in laravel with PSR coding starnadards and all coding best practices.

## Features

- Pre Integrated Admin Lte Tempalte
- Datatable With Server Side rendering
- Image Upload Functionality
- Readymade Interface and service class to use
- All classes are expandable to your need

### Step To Install

Follow each and every step to go seamless installation of admin panel

- Git Clone the project in your directory
- Go to that directory `cd laravel-core-admin`
- Install dependency `composer install`
- Install JS dependency `npm install && npm run dev`
- Copy ENV file `cp .env.example .env`
- Change Database Details inside `.env` file
- Perform `php artisan migrate`
- Perform `php artisan db:seed`
- Perform `php artisan key:generate`
- All Set ! Now run the server using `php artisan serve`

## Plugins

Laravel Core Admin is currently extended with the following plugins.
Instructions on how to use them in your own application are linked below.

| Plugin | README |
| ------ | ------ |
| Laravel AdminLTE | https://github.com/jeroennoten/Laravel-AdminLTE |
| Laravel Datatable | https://yajrabox.com/docs/laravel-datatables/10.0 |
| Laravel Breadcrumbs | https://github.com/diglactic/laravel-breadcrumbs |


## License

MIT
