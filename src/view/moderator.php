<?php
session_start();
if(!isset($_SESSION['id'])||$_SESSION['role']!='moderator'){
    
    header('Location:../../public/index.php');
    exit();
}?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Moderator page</title>
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
                    <a href="../../public/index.php">Naslovna Strana</a>
    </html>
