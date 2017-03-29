<?php
/**
 * Created by PhpStorm.
 * User: Evren Demir
 * Date: 21/02/2017
 * Time: 18:41
 */
$servername = "213.136.26.180";
$username = "web07_db";
$password = "web07";
$database_name = "web07_db";

/* // MYSQLI create connection [WERKT WEL MAAR GEEFT EEN FATAL ERROR]
 $connect_database = new mysqli($servername, $username, $password, $database_name);

 // check connection
 if($connect_database->connect_error){
     die("Connection failed: ". $connect_database->connect_error);
 }*/

//PDO create connection [WERKT WEL]
try {
    $connect_database = new PDO("mysql:host=$servername; dbname=$database_name;", $username, $password);
    print("connection OK");
} catch(PDOException $e) {
    die("connection failed: " . $e->getMessage());
}

echo "evren";
/*else{
    echo "Connected sucessfully";
}*/