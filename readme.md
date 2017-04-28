## About The Application

In order to complete a test for Modus Create, I have created an API that uses NHTSA API to get vehicle crash ratings information.

This application was created using Laravel 5.4 PHP Framework for development of the API and [GuzzleHTTP](http://docs.guzzlephp.org/en/latest/)
to make the necessaries requests for the NHTSA API and handle the responses.

## Installation

- Use Git to clone this project
- It is not necessary to configure any environment variable 
- Run composer to install the dependencies
```terminal
composer install
```
- As the application was made over Laravel 5.4 PHP Framework, start the web server running:
```terminal
php artisan serve
```
- Installation is done

## Usage

Once the installation is done, you are ready to start running the application. I recommend to use Postman Chrome plugin
or any other tool to make HTTP requests:

#### Get vehicles using GET method

```
GET http://localhost:8000/api/vehicles/<ModelYear>/<Manufacturer>/<Model>
```
For example
```
GET http://localhost:8000/api/vehicles/2015/Audi/A3
```
Should return
```
{
  "Count": 4,
  "Results": [
    {
      "Description": "2015 Audi A3 4 DR AWD",
      "VehicleId": 9403
    },
    {
      "Description": "2015 Audi A3 4 DR FWD",
      "VehicleId": 9408
    },
    {
      "Description": "2015 Audi A3 C AWD",
      "VehicleId": 9405
    },
    {
      "Description": "2015 Audi A3 C FWD",
      "VehicleId": 9406
    }
  ]
}
```

To get the Crash Rating value, you can add withRating=true to the URL:
```
http://localhost:8000/api/vehicles/2015/Audi/A3?withRating=true
```
Should return
```
{
  "Count": 4,
  "Results": [
    {
      "CrashRating": "5",
      "Description": "2015 Audi A3 4 DR AWD",
      "VehicleId": 9403
    },
    {
      "CrashRating": "5",
      "Description": "2015 Audi A3 4 DR FWD",
      "VehicleId": 9408
    },
    {
      "CrashRating": "Not Rated",
      "Description": "2015 Audi A3 C AWD",
      "VehicleId": 9405
    },
    {
      "CrashRating": "Not Rated",
      "Description": "2015 Audi A3 C FWD",
      "VehicleId": 9406
    }
  ]
}
```

#### Get vehicles using POST method

Alternatively, vehicles can be returned through POST method, setting the following parameters
- modelYear
- manufacturer
- model

For example:
```
POST http://localhost:8000/api/vehicles
{
    "modelYear": 2015,
    "manufacturer": "Audi",
    "model": "A3"
}
```
Should return exactly same result as GET method