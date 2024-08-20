<?php
session_start();

if(!isset($_SESSION['id'])||$_SESSION['id']!=1){
    header('Location:../../public/index.php');
    exit();
}
require __DIR__ . '/../../vendor/autoload.php';
require_once "../../config/connection.php";
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
if (isset($_POST['productExcel'])) {

// Assuming you have a connection to the database in $con
$query = "SELECT sif, name, count FROM products";
$result = $con->query($query);

$products = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $products[] = $row;
    }
}



    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    // Set headers for the columns
    $sheet->setCellValue('A1', 'SIF');
    $sheet->setCellValue('B1', 'Name');
    $sheet->setCellValue('C1', 'Count');

    // Fill the spreadsheet with data from the products array
    $row = 2;
    foreach ($products as $product) {
        $sheet->setCellValue('A' . $row, $product['sif']);
        $sheet->setCellValue('B' . $row, $product['name']);
        $sheet->setCellValue('C' . $row, $product['count']);
        $row++;
    }

    $filename = 'StanjeInventara.xlsx';
    $writer = new Xlsx($spreadsheet);

    // Redirect output to a client’s web browser (Excel2007)
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="' . $filename . '"');
header('Cache-Control: max-age=0');

    $writer->save('php://output');
   // header('Location:../view/admin.php');
    exit();
} else if(isset($_POST['orderExcel'])){
    $query = "SELECT orders.id AS order_id, products.sif AS product_sif, products.name AS product_name, users.id AS user_id, users.username AS user_username, orders.datum_narucivanja AS order_date FROM orders JOIN products ON products.sif=orders.product_sif JOIN users ON users.id=orders.users_id";
$result = $con->query($query);

$products = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $products[] = $row;
    }
}
$spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();
$sheet->setCellValue('A1','id Porudzbine');
$sheet->setCellValue('B1','sif Proizvoda');
$sheet->setCellValue('C1','Naziv proizvoda');
$sheet->setCellValue('D1','id korisnika');
$sheet->setCellValue('E1','username korisnika');
$sheet->setCellValue('F1','Datum porucivanja');
$row=2;
foreach ($products as $product) {
    $sheet->setCellValue('A'.$row, $product['order_id']);
    $sheet->setCellValue('B'.$row, $product['product_sif']);
    $sheet->setCellValue('C'.$row, $product['product_name']);
    $sheet->setCellValue('D'.$row, $product['user_id']);
    $sheet->setCellValue('E'.$row, $product['user_username']);
    $sheet->setCellValue('F'.$row, $product['order_date']);
    $row++;
}
$filename = 'izvestajNarudzbina.xlsx';
    $writer = new Xlsx($spreadsheet);

    // Redirect output to a client’s web browser (Excel2007)

    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="' . $filename . '"');
header('Cache-Control: max-age=0');

    $writer->save('php://output');
    //header('Location:../view/admin.php');
    exit();
}
?>

