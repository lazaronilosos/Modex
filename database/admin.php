<?php
require_once "../config/connection.php";
$losos=password_hash('Losos123$',PASSWORD_DEFAULT);
$q="INSERT INTO `users`VALUES (1,'Lazar','Milenkovic','lazaroni','$losos','admin')";
$con->query($q);
?>