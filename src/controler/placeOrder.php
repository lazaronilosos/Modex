<?php
require_once "../../config/connection.php";


session_start();

$userId = $_SESSION['id'] ?? null;
// Check if user is logged in
if (!$userId) {
    die("User not logged in.");
}


$products = $_SESSION['cart'] ?? [];
// echo "<pre>";
// print_r($products);
// echo "</pre>";
if (empty($products)) {
    die("Cart is empty.");
}

// Start a transaction
$con->begin_transaction();

try {
    foreach ($products as $sif => $count) {
        if ($sif === '') {
            unset($products[$sif]);
        } else{
        echo $sif." ".$count; 
        $stmt = $con->prepare("SELECT count FROM products WHERE sif = ?");
        $stmt->bind_param('s', $sif);
        $stmt->execute();
        $stmt->bind_result($currentCount);
        $stmt->fetch();
        $stmt->close();
echo "<br>".$currentCount;
        if ($currentCount === null) {
            throw new Exception("Product with sif $sif not found.");
        }

        $newCount = $currentCount - $count;

        if ($newCount <= 0) {
            $stmt = $con->prepare("UPDATE products SET count = NULL WHERE sif = ?");
        } else {
            $stmt = $con->prepare("UPDATE products SET count = ? WHERE sif = ?");
            $stmt->bind_param('is', $newCount, $sif);
        }

        $stmt->execute();
        $stmt->close();

        $stmt = $con->prepare("INSERT INTO orders (product_sif, users_id, datum_narucivanja) VALUES (?, ?, CURDATE())");
        $stmt->bind_param('si', $sif, $userId);
        $stmt->execute();
        $stmt->close();
        }
    }

    $con->commit();
// Upisujemo u log fajl


$file = 'spendings.txt';

$handle = fopen($file, 'a');

if ($handle) {
    $content = "User with id - ".$userId." spent a total of - ".$_POST['total']."\n";
    fwrite($handle, $content);
    fclose($handle);
    echo "Spendings appended successfully!";
} else {
    echo "Could not open the file!";
}

    unset($_SESSION['cart']);

    header('Location:../../public/index.php');
    exit();

} catch (Exception $e) {
    $con->rollback();
    echo "Error placing order: " . $e->getMessage();
}

$con->close();
?>
