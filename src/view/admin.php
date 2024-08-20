<?php
session_start();
if(!isset($_SESSION['id'])||$_SESSION['role']!='admin'){
  
    header('Location:../../public/index.php');
    exit();
}
require_once "../../config/connection.php";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if(isset($_POST['insert'])){
        // Retrieve form data and assign to variables
        $sif = isset($_POST['sif']) ? trim($_POST['sif']) : null;
        $name = isset($_POST['name']) ? trim($_POST['name']) : null;
        $cena = isset($_POST['cena']) ? floatval($_POST['cena']) : null;
        $kolicina = isset($_POST['kolicina']) ? intval($_POST['kolicina']) : 1;
        $opis = isset($_POST['opis']) ? trim($_POST['opis']) : null;
        $kategorija = isset($_POST['kategorija']) ? intval($_POST['kategorija']) : null;

        // Check if the product with the same sif already exists
        $queryCheck = "SELECT count FROM products WHERE sif = ?";
        $stmtCheck = $con->prepare($queryCheck);
        $stmtCheck->bind_param("s", $sif);
        $stmtCheck->execute();
        $stmtCheck->store_result();

        if ($stmtCheck->num_rows > 0) {
            // Product exists, update the count
            $stmtCheck->bind_result($existingCount);
            $stmtCheck->fetch();
            $newCount = $existingCount + $kolicina;

            $queryUpdate = "UPDATE products SET count = ? WHERE sif = ?";
            $stmtUpdate = $con->prepare($queryUpdate);
            $stmtUpdate->bind_param("is", $newCount, $sif);
            $stmtUpdate->execute();

            echo "Product count updated successfully.";
        } else {
            // Product does not exist, insert a new row
            $queryInsert = "INSERT INTO products (sif, name, price, count, description, category_id) 
                            VALUES (?, ?, ?, ?, ?, ?)";
            $stmtInsert = $con->prepare($queryInsert);
            $stmtInsert->bind_param("ssdisi", $sif, $name, $cena, $kolicina, $opis, $kategorija);
            $stmtInsert->execute();

            echo "New product inserted successfully.";
        }

        // Close the statements
        $stmtCheck->close();
        if (isset($stmtUpdate)) $stmtUpdate->close();
        if (isset($stmtInsert)) $stmtInsert->close();

        // Close the connection
    } else if(isset($_POST['users'])){
       $arr= isset($_POST['role'])?$_POST['role']:"";
       
       foreach ($arr as $id => $uRole) {
        $q="UPDATE users
        SET `role`=?
        WHERE id=?;
        ";
        $stmt=$con->prepare($q);
        if($stmt){
            $stmt->bind_param('si',$uRole,$id);
            $stmt->execute();
           
        } else{
            echo"SQL ERROR - couldn't prepare statement!";
        }
       }

    }

}
if(isset($_POST['kategorije'])){
    
    $q="INSERT INTO category(id,`name`) VALUES (?)" ;
    $kategorija=$_POST['kategorija'];
    $stmt=$con->prepare($q);
    if($stmt){
        $stmt->bind_param('is',$count,$kategorija);
        $stmt->execute();
        } else{
        echo "SQL ERROR - couldn't prepare statement!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin page</title>
    <link rel="stylesheet" href="css/admin.css">
</head>
<body>
    
    <h1>Ubaci novi proizvod</h1>
    <form action="admin.php" method="post">
                    <div class="polje">
                        <label for="sif">Sif</label>
                        <input type="text" id="sif" name="sif" required>
                    </div>
                    <div class="polje">
                        <label for="name">Ime proizvoda</label>
                        <input type="text" id="name" name="name" required>
                    </div>
                    <div class="polje">
                        <label for="cena">Cena</label>
                        <input type="number" id="cena" name="cena" required>
                    </div>
                    <div class="polje">
                        <label for="kolicina">Kolicina</label>
                        <input type="number" id="kolicina" name="kolicina" default="1">
                    </div>
                    <div class="polje">
                        <label for="opis">Opis</label>
                        <input type="text" id="opis" name="opis">
                    </div>
                    <div class="polje">
                        <label>Kategorija</label>
                        <input type="radio" id="torba" name="kategorija" value="1">Torba
                        <input type="radio" id="novcanik" name="kategorija" value="2">Novcanik
                        <input type="radio" id="naocare" name="kategorija" value="3">Naocare
                        <input type="radio" id="sat" name="kategorija" value="4">Sat
                        <input type="radio" id="bizuterija" name="kategorija" value="5">Bizuterija
                        <input type="radio" id="ostalo" name="kategorija" value="6" checked>Ostalo
                    </div>
                    <button type="submit" name="insert">Unesi</button>
                </form>
               <h1>Unesi novu kategoriju</h1>
                    <form action="admin.php" method="post">
                        <input type="text" name="kategorija" id="kategorija">Naziv kategorije
                        <button type="submit" name="kategorije">Prosledi</button>
                    </form>
                   <form action="../model/adminReports.php" method="post">
                       <button type="submit" name="productExcel" value="1">Stampaj izvestaj stanja prozivoda</button>
                    </form>
                    <form action="../model/adminReports.php" method="post">
                        <button type="submit" name="orderExcel" value="1">Stampaj izvestaj kupovina</button>
                    </form>
<h1>User management</h1>
<form action="admin.php" method="post">
<label for="filter">Username Filter</label>
<input type="text" name="filter" id="filter">
<button type="submit">Prosledi</button>
</form>
<?php
    if(isset($_POST['filter'])){
        $q = "SELECT * FROM users WHERE id != 1 and username LIKE ?";
        $filter=$_POST['filter'];
    }else{
        $q = "SELECT * FROM users WHERE id != 1"; 
    }
    $stmt=$con->prepare($q);
   if(isset($_POST['filter'])){
    $param='%'.$filter.'%';
    $stmt->bind_param('s',$param);
} 
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($userId, $userName, $userSurname, $userUsername, $userPassword, $userRole);
   
   if ($stmt->num_rows > 0) {
       echo "<form action='admin.php' method='post'>";
       echo "<table>
               <tr>
                   <th>Id</th>
                   <th>Ime</th>
                   <th>Prezime</th>
                   <th>Username</th>
                   <th>Password</th>
                   <th>Role</th>
                   <th>Change Role</th>
               </tr>";
   
               while ( $stmt->fetch()) {
           
   
           echo "<tr>
                   <td>{$userId}</td>
                   <td>{$userName}</td>
                   <td>{$userSurname}</td>
                   <td>{$userUsername}</td>
                   <td>/</td>
                   <td>{$userRole}</td>
                   <td>
                       <input type='radio' name='role[{$userId}]' value='admin' " . ($userRole == 'admin' ? 'checked' : '') . "> Admin<br>
                       <input type='radio' name='role[{$userId}]' value='moderator' " . ($userRole == 'moderator' ? 'checked' : '') . "> Moderator<br>
                       <input type='radio' name='role[{$userId}]' value='user' " . ($userRole == 'user' ? 'checked' : '') . "> User
                   </td>
                 </tr>";
       }
   $con->close();
       echo "</table>";
       echo "<button type='submit' name='users'>Update Roles</button>";
       echo "</form>";
   }
?>
                    <a href="../../public/index.php">Pocetna strana</a>
</body>
</html>
<?php

?>