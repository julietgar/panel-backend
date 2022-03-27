# Panel - Backend
This project is made on PHP 8 with Laravel 9 PHP Framework.

Please, follow the insctructions that are detailed below:

### Clone the project

Clone the project in your local enviroment. Run the following commands to do it:
`git clone https://github.com/julietgar/panel-backend.git`

**Now, please, make sure to run the next commands in the root of your project.**

### Create an environment file
`cp .env.example .env`

### Install packages
Before to run this, make sure you have installed [Composer](https://getcomposer.org/) in your system.

`composer install`

### Initialize the project
Run the following command to initialize the project with [Docker Desktop](https://www.docker.com/products/docker-desktop/):

`./vendor/bin/sail up`

The first time you run the Sail up command, Sail's application containers will be built on your machine. This could take several minutes.

##### Generate an app key
When previous process is completed, please, open another terminal tab and run this:
`./vendor/bin/sail php artisan key:generate`

Once the application's Docker containers have been started, you can check if the application is on accessing in your web browser: http://localhost.

### Create tables:
Run this command to create the tables required in the database:
    `./vendor/bin/sail php artisan migrate --seed`

This command is going to create some table and insert some predifine data for the `machine` and `machine_settings` tables.

### How to use it?
There is a job created to take the data from the Pump CSV file and insert them in the database.

We have to run the following commands to be sure that the flow can work properly:

- Run Horizon:
`./vendor/bin/sail php artisan horizon`

   Horizon can help you to manage and handle the queues in the server.

- Dispatch the `PumpProcess` job:
   In another tab, run this command:
`./vendor/bin/sail php artisan tinker --execute "Bus::dispatch(new App\Jobs\PumpProcess());"`

   This is the job necessary to insert data in the database.

- Run the job scheduled automatically (optional):
   In another tab, run this command:
`./vendor/bin/sail php artisan schedule:work`

   This command will run in the foreground and invoke the scheduler every minute until. 
The `PumpProcess` job has been scheduled to be run every minute. If you would like to try it, you can use this command and wait every minute. You do not have to dispatch the `PumpProcess` job manually.

### Run the tests

You can run the tests with the following command:
`./vendor/bin/sail php artisan test`

### Follow the instructions to use panel-frontend here:
https://github.com/julietgar/panel-frontend/blob/dev/README.md

