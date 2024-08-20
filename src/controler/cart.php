<?php

require_once __DIR__ . "/../../vendor/autoload.php";
require_once "cartValidation.php";
session_start();
$sif= $_POST['sif'];
$count=(int)$_POST['count'];
$filter=isset($_POST['filter'])?$_POST['filter']:[];

echo '<pre>';
print_r($_POST);
echo '</pre>';
$param=[];
$string="?";
if(!empty($filter)){
    foreach ($filter as $key => $value) {
        if($key=='vise'){
            $param[]="viseod=$value";
        } else if($key=='manje'){
            $param[]="manjeod=$value";
        } else {
            $param[]="filterkat[]=$value";
        }
    }
    $string.=implode("&",$param);
} else{
$string="";
}
$count1=0;
if (isset($_SESSION['cart'][$sif])) {
    $count1+= (int)$_SESSION['cart'][$sif] ;
} 
if(amountCheck($sif,$count1)){
    $url='Location:../model/shop.php'.$string.'&Error='.amountCheck($sif,$count1);
    header($url);
    exit();
} else{
    if(!isset($_SESSION['cart'])){
        $_SESSION['cart']=[];
    }
    if(isset($_SESSION['cart'][$sif])){
        $_SESSION['cart'][$sif]=$count+(int)$_SESSION['cart'][$sif];
    } else{
        $_SESSION['cart'][$sif]=$count;
    }
    $url='Location:../model/shop.php'.$string;
    
    header($url);
   exit();
}



?>