## Version Info:
<p>Laravel 6.20</p>
<p>You will need node.js version 10.23 and npm version 6.14.8</p>

## Requirements
<ul>
<li>composer require laravel/ui 1.* [because Laravel 6 supports this version]</li>
<li>A mailtrap.io account. Add details to .env file</li>
</ul>

##.env changes
1. APP_NAME="Your app name"

2. DB_DATABASE="Your database name"
   DB_USERNAME="Your DB username"
   
3. QUEUE_CONNECTION=database

4. MAIL_USERNAME="Your mailtrap username"
   MAIL_PASSWORD="Your mailtrap password"
   MAIL_FROM_ADDRESS="An mail from address"
   <h5> Admin email address</h5>
   APP_ADMIN_EMAIL=email@email.com

## Create User
To add and delete question you need to register as a user. 
You can do it simply by Laravel's default "Register" option. 

## Scheduler Setup

<h5>For Test 2: a job that runs every two days at 8am UTC </h5>
    php artisan queue:listen
    
<h5>For Test 2 &amp; Test 3:</h5>

<h6>Locally</h6>
    php artisan schedule:run

<h6>On Server's Crontab</h6>
First let’s set it up, by adding our single Cron entry, on the server. As follows:

1) Type crontab -e

2) At the last line add the following: * * * * * php /path-to-your-project/artisan schedule:run >> /dev/null 2>&1

Don’t forget to replace the path-to-your-project.


<h3>For Test 4:</h3>
Route: http://localhost:8000/surveys

## Test 5:
Not included
