<?php 

require_once '../config/db.php';

try {
    $pdo = new PDO("mysql:host=".$db['host'].";dbname=".$db['name'],$db['user'],$db['password']);
    $pdo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING );
}catch (\PDOException $e) {
    header('HTTP/1.0 500 Database connection error');
    echo 'Database connection error';
}