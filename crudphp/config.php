<?php

$dbname = 'crud';
$dbhost = 'localhost';
$dbuser = 'root';
$dbpassword = '';

$pdo = new PDO("mysql:dbname=".$dbname.";host=".$dbhost, $dbuser, $dbpassword);