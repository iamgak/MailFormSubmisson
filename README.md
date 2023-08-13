# MailFormSubmisson
## About project
It's a php-mysql Script where user fill form details.First it validate form using core PHP without Javascript.Then the form is sent to Admin is email using core PHP functions. 
## Technology used
HTML<br>
CSS<br>
PHP<br>
MySQL<br>
## Database Schema
"create database if not exists submisson"
"create table if not exists inputData (
        name varchar(40) not null,
        email varchar(50) primary key,
        phone varchar(20) not null,
        subject varchar(30),
        message TEXT,
        submission_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        
    )"
## How to use
just run FormMail.php on localhost


