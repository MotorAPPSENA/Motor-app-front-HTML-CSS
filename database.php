<?php
    $server = 'localhost';
    $username ='root';
    $password = '1706';
    $database = 'motor_app_db';
    try {
        $conn = new PDO("mysql:host=$server;dbname=$database;",$username,$password);
        //code...
    } catch (PDOException $e) {
        die ("Falla en la conexión:: ". $e->getMessage());
        //throw $th;
    }
?>