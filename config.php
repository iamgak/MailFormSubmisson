<?php
$host="localhost"; $username="root"; $password=""; $db_name="submisson";
$db = new mysqli($host, $username, $password,$db_name);
        if ($db->connect_error) {
            die("Connection failed: " . $db->connect_error);
}
$db->query("create database if not exists submisson");
$result=$db->query("create table if not exists inputData (
        name varchar(40) not null,
        email varchar(50) primary key,
        phone varchar(20) not null,
        subject varchar(30),
        message TEXT,
        submission_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        
    )");

?>