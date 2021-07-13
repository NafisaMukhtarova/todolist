<?php

$mysqli = new mysqli("localhost","root","Qq12345678","my_db");

$mysqli->query ("SET NAMES 'utf8'");

$mysqli->query("SET CHARACTER SET 'utf8';");
$mysqli->query("SET SESSION collation_connection = 'utf8_general_ci';");

echo 'start';

//$success = $mysqli->query ("INSERT INTO contacts (name) VALUES ('Shoshan')");
$success = 0;
//$success = $mysqli->query ("UPDATE  contacts SET address= 'Коломбо', surname = 'Синнатамби', phone_number='+79378610530' WHERE name = 'Shoshan' ");
$success = $mysqli->query ("INSERT INTO users (name) VALUES ('Шошан')");


var_dump ($success);



$mysqli -> close ();






?>