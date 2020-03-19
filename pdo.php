<?php
$servername = "localhost";
$username = "newuser";
$password = "Passwordhkd";

$pdo = new PDO("mysql:host=$servername;dbname=misc2", $username, $password);
// See the "errors" folder for details...
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);




