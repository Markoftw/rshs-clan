<?php
ini_set('display_errors',"1");
try{
    $mysqli = new PDO("mysql:host=localhost;dbname=rshsclan", "USERNAME_CHANGE", "PASSWORD_CHANGE");
} catch (Exception $ex) {
    die("Error: " . $ex->getMessage());
}

?>