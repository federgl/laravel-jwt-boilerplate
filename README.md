# Laravel JWT Auth Core API

# Technology
This application is built using Laravel v5.7

Dependencies should be installed with composer.

Composer can be a useful tool for installing newer Laravel versions and dependencies.

# What's Included?

* Laravel 5.7 (https://laravel.com/docs/5.7)
* Laravel Telescope (https://laravel.com/docs/5.7/telescope)
* Laravel Log Viewer (https://github.com/rap2hpoutre/laravel-log-viewer)
* Sentry.io (https://www.sentry.io)
* Dingo API (https://github.com/dingo/api)
* Tinker (https://github.com/laravel/tinker)
* JWT Auth (https://jwt.io)
* Jenkins (https://jenkins.io/)
* Spatie Roles and Permissions (https://github.com/spatie/laravel-permission)

# Getting Started
Ensure the following requirements are met in order to run the project properly:

* Docker (https://www.docker.com/get-started)
* Docker Compose (https://docs.docker.com/compose/)

# General Considerations:

* You should not add any port information inside the docker compose file of this project, it's supposed to use the one already setup and the domain you set on /etc/hosts file.
* For sentry you'll need to create an account (or use yours if already has it) and from there you'll be able to take the required link, paste it on the .env file at -> SENTRY_LARAVEL_DSN place.
* Take in count, that when running ```docker-compose up -d```, we have to run it as a non root user. I mean logged in as a common user, and without ```sudo```.

# Instructions (on linux environments):

1) Make sure docker and docker compose are installed on your host system.
2) Clone this repository
3) Go inside ```laravel-jwt-starter``` folder
4) Copy .env.example into .env
5) Set on .env file the following parameters
    * API_PREFIX=api
6) Run ```docker-compose up -d```, this will start four containers
    * App container
    * Nginx container
    * Database container
    * Jenkins container
7) Go inside db container, execute ```docker exec -it db bash -l```
8) Once inside the container you are logged in as root, just create an empty schema. For this we first need to login:
    * ```mysql -uroot -p``` and the password from .env (default one is ```your_mysql_root_password```)
9) Once logged in, run ```create schema laravel_test;```. After successful creation of the database, just go out of mysql console, and from container.
    * Run ```exit```, twice.
10) Standing on ```laravel-jwt-starter``` folder, run ```docker-compose exec app php artisan migrate --seed```. 
     * Great! Now you have the db created, and with test data populated! (See ```#testing``` for information on testing data).
11) On same folder from #10, run:
     *  ```docker-compose exec app php artisan config:clear``` 
12) Then, standing on same folder run:
     *  ``` php artisan key:generate ```
13) Finally, go inside /etc/hosts and add this line
    * 127.0.0.1             laravel.local.com
14) Okey!, we reach the end!, Just go to:
    * ```laravel.local.com:8080```
    and you should see a page showing ```Laravel JWT - Home``` in the middle! That means that app is running!

# Documentation

Description for base endpoints provided here can be seen running ```http://laravel.local.com:8080/api/documentation``` after you set up the project locally successfully.

For database structure diagram, please visit (https://drive.google.com/file/d/1RyMbQQY_dIYqT3ufD4baTGlCQm-5_3bm/view?usp=sharing)

# Logging

A custom log is defined to have historical records. It's called ```api_operations.log```, and can be found on ```storage/logs```

# Email setup

The project contains the functionality to validate the user account after register by sending an email through (for example) gmail, so make sure you setup a valid sending account on .env parameters:
    * MAIL_USERNAME
    * MAIL_PASSWORD
Remember that if you are using a google account, you first need to allow google sending this kind of emails. You can see how to do it here (https://support.google.com/accounts/answer/6010255?hl=en)

# Jenkins

Previous to start, please open a new terminal window, then follow this steps:

1) Get inside Jenkins container by running ```docker exec -it jenkins /bin/sh```
2) Run ```cd /var/jenkins_home/secrets/```
3) Run ```cat initialAdminPassword```
4) Now you will see on the terminal, the admin password, you have to copy it on your clipboard.
5) Go to ```localhost:5000```
6) On the page that's opened, look for a box where the admin password is requested
7) Here you can choose if installing the recommended tools, or if you want to customize them. 
8) Wait until installation ends
9) Follow setup requirements
10) After setup is done, jenkins is setted up and running, so everytime you visit ```localhost:5000``` you will see the jenkins dashboard!

# Testing the api


## Existent testing data
If you are reading here looking for the testing data, only one valid user is created on the system already marked as an activated user for initial uses:

*  Email: ``` federeale@globant.com ```
*  Password: ``` secret ```

With those credentials you will be able to test the core api developed here without creating any new user.

## Tests tools and behaviour
Then, you'll need to know that in this application we are using two types of testing. Unit and functional testing, unit testing is implemented with the sebastian bergmann php unit library (https://phpunit.de/), and the functional testing is being done with the out of the box laravel functionalities (https://laravel.com/docs/5.7/http-tests)

To be able to run the tests, you'll need to get logged into the docker machine, so follow this steps and that's all!

To achieve this just execute:

``` docker exec -it app /bin/sh```

## Unit Testing - Instructions
1) Now you are logged in as sudo user, and standing on ```/var/www``` folder. So, to run feature tests run:

```./vendor/bin/phpunit --testsuite Feature```

In case you want to run unit tests:

```./vendor/bin/phpunit --testsuite Unit```

Finally, in order to run both tests all together run:

```./vendor/bin/phpunit```

and you'll see unit testing start execution, once finished, result will be displayed on the console this way (example show success scenario):

```OK (1 test, 4 assertions)```

2) That's it, now we should guarantee that every time we execute the tests before making any PR, they all gets success status. 

## Manual Testing - Instructions

1) Get postman (http://getpostman.com)
2) Once you have the app (or extension) installed, find the ```import``` button at the right top of the screen.
3) Click it, and a modal will apear. There you'll need to find the ```import from link``` option.
4) When link is prompted, just insert this one (https://www.getpostman.com/collections/b705d7cf4c6a83c7681c)
5) Okey!, now you will be able to see, and use the testing set from the Collections panel, located at postman's sidebar.