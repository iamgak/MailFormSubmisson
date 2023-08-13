# MailFormSubmisson
## About project
It's a php-mysql Script where user fill form details.First, validation of form data using core PHP. It involve checking of all the form details  in respective format using preg_match(),strlen(),empty() and various other functions and after that removal of htmlspecialchar and other scripting part from input data.Then the form is sent to Admin through email using PHP functions mail() and it also record its detail in mysql server. This script does not include any JS part.<br>
It's fully Object Oriented code.
## Glimpses
<img src="/mail.png" alt="this is login page">
<img src="/error.png" alt="this is login page"><img src="/submisson.png" alt="this is login page"><img src="/FormMail.png" alt="this is login page">
## Technology used
HTML<br>
CSS<br>
PHP<br>
MySQL<br>
## Database Schema
"create database if not exists submisson"
<br>
"create table if not exists inputData (
        name varchar(40) not null,
        email varchar(50) primary key,
        phone varchar(20) not null,
        subject varchar(30),
        message TEXT,
        submission_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP)"
## How to use
just run FormMail.php on localhost


