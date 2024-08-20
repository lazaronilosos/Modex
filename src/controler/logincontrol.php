<?php 
require_once "../../config/connection.php";
session_start();
$id=$_GET['id'];

$_SESSION['id']=$id;

if($_SESSION['id']==1){
    $_SESSION['role']='admin';
    header('Location:../view/admin.php');
    exit();
} else{
    $q="SELECT `role` FROM users WHERE id=?";
    if($stmt=$con->prepare($q))
    {
        $stmt->bind_param('i',$_SESSION['id']);
        $stmt->execute();
        $stmt->bind_result($role);
        $stmt->store_result();
        $stmt->fetch();
        $stmt->close();
        $_SESSION['role']=$role;
        if($role=='moderator'){
            header('Location:../view/moderator.php');
            exit();
        } else{
            header('Location:../../public/index.php');
            exit();
        }
    } else{
        echo "SQL ERROR - couldn't prepare statement!";
    } 
}
?>