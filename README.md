# CSV Importer

A simple app to import cars from a CSV file.

## Setup

git clone git@github.com:enfie01s/csv-importer.git

Create your .env file based on .env.example with your settings

### Installing in standalone mode (without the docker wrapper)

```
composer install
php artisan key:generate

```

## Endpoints

/import Imports the file stored in the public directory

/export/ford exports the vehicles with desired make (in this case 'ford') to the ftp server of your choice.
