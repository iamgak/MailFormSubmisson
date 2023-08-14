# MailFormSubmisson
## About project
It's a php-mysql Script where user fill form details.First, validation of form data using core PHP. It involve checking of all the form details  in respective format using preg_match(),strlen(),empty() and various other functions and after that removal of htmlspecialchar and other scripting part from input data.Then the form is sent to Admin through email using PHP functions mail() and it also record its detail in mysql server. This script does not include any JS part.<br>
It's fully Object Oriented code.
<h3> Glimpses</h3>
<img src="/images/submisson.png" alt="this is login page">
<img src="/images/mail.png" alt="this is login page">
<img src="/images/error.png" alt="this is login page">
<img src="/images/SqlErro.png">
<h3> Technology used</h3>
HTML<br>
CSS<br>
PHP<br>
MySQL<br>
<h3>Database Schema</h3>
"create database if not exists submisson"
<br>
``` 

create table if not exists inputData (
        name varchar(40) not null,
        email varchar(50) primary key,
        phone bigint not null,
        subject varchar(30),
        message TEXT,
        submission_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP);
        

```

## How to use
just run FormMail.php on localhost


