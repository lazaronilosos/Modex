<?php
require_once "../../config/connection.php";
require_once "../../vendor/autoload.php";
use App\model\productClass;
use Twig\Loader\FilesystemLoader;
use Twig\Environment;
session_start();
$sum;
$sif;
$products=isset($_SESSION['cart'])?$_SESSION['cart']:[];

$arr=[];
$totalPrice=0;
foreach($products as $sif => $count){
$q="SELECT name, price, description FROM products WHERE sif=?";
if($stmt=$con->prepare($q)){
$stmt->bind_param('s',$sif);
$stmt->execute();
$stmt->bind_result($name,$price,$description);
while ($stmt->fetch()) {
    $product = new productClass($sif, $name, $price, $count, $description);
   // $product->display();
   $totalPrice+=$product->getSumPrice();
    $arr[] = $product;
}
} else{
    echo "SQL ERROR - couldn't prepare statement";
}
}
$con->close(); 
$loader = new FilesystemLoader(__DIR__ . '/../view');
$twig = new Environment($loader, [
    'cache' => false,
]);

try {
    echo $twig->render('cart.html.twig', [
        'products' => $arr,
        'total' => $totalPrice
    ]);
} catch (\Twig\Error\Error $e) {
    echo 'Twig error: ' . $e->getMessage(); 
}

?>