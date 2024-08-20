<?php
require_once __DIR__ . "/../../vendor/autoload.php";
require_once "../../config/connection.php";
use Twig\Loader\FilesystemLoader;
use Twig\Environment;
session_start();

$q1 = "SELECT sif, name, price, count, description, category_id FROM products ";
$q2 = "SELECT COUNT(*) as brojac FROM products ";

$condition = [];
$filters = []; // Array to store filters for passing to Twig

if ($_SERVER['REQUEST_METHOD'] === 'POST' || $_SERVER['REQUEST_METHOD'] === 'GET') {
    $filterkat = isset($_REQUEST['filterkat']) ? $_REQUEST['filterkat'] : [];
    $viseod = isset($_REQUEST['viseod']) ? $_REQUEST['viseod'] : '';
    $manjeod = isset($_REQUEST['manjeod']) ? $_REQUEST['manjeod'] : '';

    // Handle category filtering with OR condition
    if (!empty($filterkat)) {
        $categoryConditions = [];
        foreach ($filterkat as $category) {
            $categoryConditions[] = "category_id=" . intval($category);
        }
        $condition[] = "(" . implode(" OR ", $categoryConditions) . ")";
        $filters['filterkat'] = $filterkat;
    }

    // Handle price filtering with AND condition
    if (!empty($viseod)) {
        $vise = floatval($viseod);
        $condition[] = "price >= " . $vise;
        $filters['viseod'] = $viseod;
    }
    if (!empty($manjeod)) {
        $manje = floatval($manjeod);
        $condition[] = "price <= " . $manje;
        $filters['manjeod'] = $manjeod;
    }
}

if (!empty($condition)) {
    $conditionString = " WHERE " . implode(" AND ", $condition);
    $q1 .= $conditionString;
    $q2 .= $conditionString;
}

$results = $con->query($q2);
$result = $results->fetch_assoc();
$totalProducts = $result['brojac'];

$pageProductsNum = 9;
$totalPages = ceil($totalProducts / $pageProductsNum);
$currPage = isset($_GET['currpage']) ? (int)$_GET['currpage'] : 1;
$productsStartingPoint = ($currPage - 1) * $pageProductsNum;

$q1 .= " LIMIT ?, ?";
$stmt = $con->prepare($q1);
$stmt->bind_param('ii', $productsStartingPoint, $pageProductsNum);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($sif, $name, $price, $count, $description, $category_id);

$arr = [];
$role = isset($_SESSION['role']) ? $_SESSION['role'] : "";

while ($stmt->fetch()) {
    $arr[] = [
        'sif' => $sif,
        'name' => $name,
        'price' => $price,
        'count' => $count,
        'description' => $description,
        'category_id' => $category_id
    ];
}

$loader = new FilesystemLoader(__DIR__ . '/../view');
$twig = new Environment($loader, [
    'cache' => false,
]);

try {
    echo $twig->render('shop.html.twig', [
        'role' => $role,
        'products' => $arr,
        'totalPages' => $totalPages,
        'currentPage' => $currPage,
        'filters' => $filters // Pass the filters to Twig
    ]);
} catch (\Twig\Error\Error $e) {
    echo 'Twig error: ' . $e->getMessage(); 
}
?>