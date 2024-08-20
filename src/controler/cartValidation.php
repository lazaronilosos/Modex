<?php
require_once "../../config/connection.php";
function amountCheck($sif,$count){
$q="SELECT count, `name` FROM products WHERE sif=?";
global $con;
if($stmt=$con->prepare($q)){
    $stmt->bind_param('s',$sif);
    $stmt->execute();
    $stmt->bind_result($maxCount, $naziv);
    $stmt->fetch();
    if($count>$maxCount){
        return "Nemamo dovoljno proizvoda na stanju, dostupno je jos ". $maxCount . " ". $naziv;
    } else{
        return false;
    }
} else{
    echo "SQL ERROR - couldn't prepare statement";
}

}

?>