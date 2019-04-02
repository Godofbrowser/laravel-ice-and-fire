## Laravel Ice & Fire



### Installation
 - Clone the repo
 - Change directory to the cloned project folder
 - Run: `composer install` command
 - Copy .env.example to .env
 - Run: `php artisan key:generate`
 - Create a database
 - Configure .env with database credentials
   - DB_DATABASE=yourDatabaseName
   - DB_USERNAME=yourMysqlUsername
   - DB_PASSWORD=yourPassword
 - Run: `php artisan optimize`
 - Run: `php artisan migrate`
 - Run: `php artisan serve`
 
 App should be served at **http://localhost:8000**
 This will be the initial base url on the postman collection (postman-collection.json) located n the project root.
 
 Next, import postman collection into postman and you should be able to test the endpoints
 
 