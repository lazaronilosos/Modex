<?php
$dbconfig= require "configConnection.php";
$con=new mysqli(
    $dbconfig['localhost'],
    $dbconfig['username'],
    $dbconfig['password'],
    $dbconfig['db']
);
$con->set_charset($dbconfig['charset']);
if($con->connect_error){
    die("Neuspesna konekcija na bazu: ".$con->connect_error);
}
?>