<?php
   $server = 'localhost';
   $username ='u321233860_Motorapp';
   $password = 'Hernan3014200329*';
   $database = 'u321233860_motor_app_db';
    try {
        $conn = new PDO("mysql:host=$server;dbname=$database;",$username,$password);
        //code...
    } catch (PDOException $e) {
        die ("Falla en la conexión:: ". $e->getMessage());
        //throw $th;
    }
?>