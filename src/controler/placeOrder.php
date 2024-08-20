<?php
require_once "../../config/connection.php";


session_start();

// Assuming user ID is stored in the session
$userId = $_SESSION['id'] ?? null;
// Check if user is logged in
if (!$userId) {
    die("User not logged in.");
}

// Get the products array from the session (from the cart)
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
        // Fetch current product count from the database
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

        // Calculate the new count after purchase
        $newCount = $currentCount - $count;

        // If the product is fully purchased, set count to NULL, otherwise update it
        if ($newCount <= 0) {
            $stmt = $con->prepare("UPDATE products SET count = NULL WHERE sif = ?");
        } else {
            $stmt = $con->prepare("UPDATE products SET count = ? WHERE sif = ?");
            $stmt->bind_param('is', $newCount, $sif);
        }

        // Execute the update
        $stmt->execute();
        $stmt->close();

        // Insert the order into the orders table
        $stmt = $con->prepare("INSERT INTO orders (product_sif, users_id, datum_narucivanja) VALUES (?, ?, CURDATE())");
        $stmt->bind_param('si', $sif, $userId);
        $stmt->execute();
        $stmt->close();
        }
    }

    // Commit the transaction
    $con->commit();

    // Clear the cart after placing the order
    unset($_SESSION['cart']);

    header('Location:../../public/index.php');
    exit();

} catch (Exception $e) {
    // Rollback the transaction in case of error
    $con->rollback();
    echo "Error placing order: " . $e->getMessage();
}

// Close the database connection
$con->close();
?>
