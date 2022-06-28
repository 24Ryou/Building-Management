<?php
$host = 'localhost';
$user = 'root';
$password = '';
$dbname = 'building-managment';
$charset = 'utf8mb4';
try {
    // Set DSN
    $dsn = 'mysql:host=' . $host . ';dbname=' . $dbname . ';charset=' . $charset;
    $pdo = new PDO($dsn, $user, $password);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    // echo 'successfull connection;
} catch (PDOException $error) {
    $error->getMessage();
    echo "database faild to connect!!";
}