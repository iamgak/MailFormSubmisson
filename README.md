# MailFormSubmisson
## About project
It's a php-mysql Script where user fill form details.First it validation of form using core PHP without Javascript it involve all the form details should be in respective format using preg_match(),strlen(),empty() and various other functions and after that removal of htmlspecialchar and other scripting part from input data.Then the form is sent to Admin through email using core PHP functions mail() and it also record its detail in mysql server. 
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


