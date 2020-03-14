# Laravel Vue Comment Widget

The purpose of this project was to learn more about the PHP Framework Laravel. 

The project is a simple commenting widget, or area, that uses AJAX to save a comment to a database, as well as retrieve the comments from a database. 

This project is built using Laravel, Vue, and MySQL.

### Setting up the Project

1. Clone the repo to your local machine
2. Create a `.env` file using the values from the `.env.example`
3. Run `npm i && composer install` at the root of the project to install the packages
4. Run `php artisan migrate` to set up databases

Now that everything is set up, see the next sections for running the project in a development or production setting. 

### Running the Project in a Development setting

1. Open a terminal and run `npm run watch` to build the front end of the project.
2. Open a second terminal and run `php artisan serve` to run the project

### Running the Project in a Production setting

1. Run `npm run prod` to build the front end for production. 
2. Reference [this document](https://laravel.com/docs/master/deployment) on how to deploy the project. 