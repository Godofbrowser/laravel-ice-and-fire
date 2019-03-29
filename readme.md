## Laravel Ice & Fire



### Installation
 - Clone the repo
 - Run: `composer install` command
 - Create a database
 - Copy .env.example to .env
 - Configure .env with database credentials
 - Run: `php artisan key:generate`
 - Run: `php artisan optimize`
 - Run: `php artisan migrate`
 - Run: `php artisan serve`
 
 App should be served at **http://localhost:8000**
 This will be the initial base url on the postman collection (postman-collection.json) located n the project root.
 
 Next, import postman collection into postman and you should be able to test the endpoints
 
 