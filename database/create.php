<?php
require_once "../config/connection.php";

$q="CREATE TABLE users(
id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
`name` VARCHAR(50) NOT NULL,
`surname` VARCHAR(50) NOT NULL,
username VARCHAR(50) NOT NULL,
`password` VARCHAR(255) NOT NULL,
`role` ENUM('admin','moderator','user') not null default 'user'
)ENGINE=INNODB;
";
$q.="CREATE TABLE category(
    id INT NOT NULL auto_increment PRIMARY KEY,
    `name` VARCHAR(50) NOT NULL
    )ENGINE=INNODB;";
$q.="CREATE TABLE products(
sif VARCHAR(50) NOT NULL PRIMARY KEY,
`name` VARCHAR(50) NOT NULL,
price DECIMAL(10,2) NOT NULL,
count INT,
`description` VARCHAR(100),
category_id INT NOT NULL,
FOREIGN KEY(category_id)
REFERENCES category(id)
ON UPDATE CASCADE ON DELETE RESTRICT
)ENGINE=INNODB;";
$q.="CREATE TABLE orders(
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    product_sif VARCHAR(50) NOT NULL,
    users_id INT NOT NULL,
    datum_narucivanja DATETIME NOT NULL,
    FOREIGN KEY(users_id)
    REFERENCES users(id)
    ON UPDATE CASCADE ON DELETE RESTRICT,
    FOREIGN KEY(product_sif)
    REFERENCES products(sif)
    ON UPDATE CASCADE ON DELETE RESTRICT
    )";
if($con->multi_query($q)){
    echo "Tables successfully created!";
} else{
    echo "SQL ERROR - couldn't execute query:".$con->error;
}
?>