<?php 
require_once "../config/connection.php";
session_start();
$q="SELECT sif,	`name`, price, `description`
FROM products WHERE count IS NOT NULL
ORDER BY category_id
LIMIT 9;
";

if($stmt=$con->query($q)){
	$rows=$stmt->fetch_all(MYSQLI_ASSOC);
} else{
	echo "SQL ERROR - couldn't prepare statement!";
}
?>

<!DOCTYPE HTML>
<!--
	Editorial by HTML5 UP
	html5up.net | @ajlkn
	Free for personal and commercial use under the CCA 3.0 license (html5up.net/license)
-->

<html>
	<head>
		<title>Dobrodošli na zvaničnu stranicu Modex Moda plus</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
		<link rel="stylesheet" href="assets/css/main.css" />
	</head>
	<body class="is-preload">

		<!-- Wrapper -->
			<div id="wrapper">

				<!-- Main -->
					<div id="main">
						<div class="inner">

							<!-- Header -->
								<header id="header">
									
									<ul class="icons">
										
									<li><a href="../src/model/cart.php" class="icon solid fa fa-shopping-cart" style="font-size:36px><span class="label">Korpa</span></a></li>
										<li class="icon solid fa-phone" > <span class="lakikaki">+381 64 1239911</span> </li>
										<li><a href="https://www.facebook.com/GiftShopModexModaPlus" class="icon brands fa-facebook-f"><span class="label">Facebook</span></a></li>
										<li><a href="https://www.instagram.com/modexmodaplusnis/" class="icon brands fa-instagram"><span class="label">Instagram</span></a></li>
										<li><a href="#" class="icon brands fa-medium-m"><span class="label">Medium</span></a></li>
									</ul>
								</header>

							<!-- Banner -->
								<section id="banner">
									<div class="content" id="lakikaki">
										<div class="laki">
										<header>
											<h1>Dobrodošli na stranicu<br />
												Modex Moda plus</h1>
											<p>Online prodavnicu za satove, nakit, naočare, ručne torbe i još mnogo toga</p>
										</header>
										<p> Modex moda već godinama sa našim kupcima deli strast prema modi, inspirišemo ih da budu najbolja verzija sebe i pružamo iskustvo kupovine u nezaboravnoj atmosferi koja donosi trenutke čistog zadovoljstva. Naše poslovanje zasnovano je na transparentnom i fer odnosu prema brendovima koje zastupamo, zaposlenima, potrošačima i životnoj sredini. Modex moda nastavlja da raste u polju retail prodavnica i stalno uzima nove brendove! </p>
										</div>
										<ul class="actions">
											<li><a href="#postss" class="button big" id="scroll-smooth">Pogledaj Ponudu</a></li>
											
										</ul>
									</div>
									<span class="image object">
										<img src="images/store.jpg" alt="" />
									</span>
								</section>

							<!-- Section -->
								<section>
									<header class="major">
										<h2>Informacije</h2>
									</header>
									<div class="features">
										<article>
											<span class="icon fa-gem"></span>
											<div class="content">
												<h3>Lokacija</h3>
												<p>Modex Moda plus ima odličnu lokaciju u Duvaništu, u sklopu samog objekta super marketa Aman, Majakovskog BB, Niš 18000, Srbija.</p>
											</div>
										</article>
										<article>
											<span class="icon solid fa-paper-plane"></span>
											<div class="content">
												<h3>Kontakt</h3>
												<p>Mozete nas kontaktirati preko kontakt-telefona +381 64 1239911, preko mejla online modexmodaplus@gmail.com, ili preko naše instagram stranice modemodaplusnis</p>
											</div>
										</article>
										<article>
											<span class="icon solid fa-rocket"></span>
											<div class="content">
												<h3>Radno vreme</h3>
												<p>Za naše drage kupce otvoreni smo od 10h-21h od ponedeljka do subote!</p>
											</div>
										</article>
										<article>
											<span class="icon solid fa-signal"></span>
											<div class="content">
												<h3>Nastanak</h3>
												<p>Od samog nastanka 2004. Modex Moda nudi mnogo više od kupovine. Modex online shop je lansiran 2024. godine gde smo vam danas dostupni 24h!</p>
											</div>
										</article>
									</div>
								</section>

							<!-- Section -->
								<section>
									<header class="major">
										<h2>Shop</h2>
									</header>
									<div class="posts" id="postss">
										<?php 
										foreach ($rows as $row) {
										$sif=$row['sif'];	$name=$row['name']; $price=$row['price']; $description=$row['description'];
										if(isset($_SESSION['id'])){
											$pom="cart.php?sif=$sif";
										} else{
											$pom="login.php";
										}
										echo '<article>
										<a href="#" class="image"><img src="images/' . $sif . '.jpg" alt="" /></a>
										<h3>' . $name . '</h3><span>'.$price.'&#8364;</span>
										<p>' . $description . '</p>
										<ul class="actions"> 
											<li><a href="../src/controler/' . $pom . '" class="button">Dodaj u korpu</a><span><input type="number" name="counter" id="counter" min="1" max="9" step="1" value="1"></span></li>
										</ul>
									</article>';
									} ?>
									
									</div>
									<ul class="actions">
											<li><a href="<?php if(isset($_SESSION['id'])){
											echo"../src/model/shop.php"; 
											}else{
												echo"../src/view/login.php";
											}?>" class="button">Kompletna ponuda</a></li>
											<li><a href="<?php if(isset($_SESSION['id'])){
											echo"../src/model/cart.php"; 
											}else{
												echo"../src/view/login.php";
											}?>" class="button">Korpa</a></li>
										</ul>
								</section>

						</div>
					</div>

				<!-- Sidebar -->
					<div id="sidebar">
						<div class="inner">

							<!-- Search -->
							

							<!-- Menu -->
								<nav id="menu">
									<header class="major">
										<h2>Meni</h2>
									</header>
									<ul>
									<li><a href="#">Naslovna Strana</a></li>
										<?php if(empty($_SESSION['id'])){
											echo "<li><a href='../src/view/login.php'>Uloguj se</a></li>";
										} ?>
										<?php if(isset($_SESSION['id'])&&$_SESSION['id']==1){
											echo "<li><a href='../src/view/admin.php'>Admin stranica</a></li>";
										} ?>
										<?php if(isset($_SESSION['id'])&&$_SESSION['role']=='moderator'){
											echo "<li><a href='../src/view/moderator.php'>Moderator stranica</a></li>";
										} ?>
										
									<li><a href="../src/model/shop.php?filterkat[]=4">Satovi</a></li>
										<li><a href="../src/model/shop.php?filterkat[]=1">Torbe</a></li>
										<li><a href="../src/model/shop.php?filterkat[]=3">Naocare</a></li>
										<li><a href="../src/model/shop.php?filterkat[]=2">Novčanici</a></li>
										<li><a href="../src/model/shop.php?filterkat[]=5">Bizuterija</a></li>
										<li><a href="../src/model/shop.php?filterkat[]=6">Ostali predmeti</a></li>
										<?php if (isset($_SESSION['id'])){
											echo "<li><a href='../src/controler/logout.php'>Izloguj se</a></li>";
										}?>
									</ul>
								</nav>

							<!-- Section -->
								<section>
									<header class="major">
										<h2>Aktuelnosti iz sveta mode</h2>
									</header>
									<div class="mini-posts">
										<article>
											<a href="#" class="image"><img src="images/sat.jpg" alt="" /></a>
											<p>Pogledaj našu raznovrsnu ponudu u oblasti satova! </p>
										</article>
										<article>
											<a href="#" class="image"><img src="images/cvaje.jpg" alt="" /></a>
											<p>Pogledaj našu raznovrsnu ponudu u oblasti naočara!</p>
										</article>
										<article>
										<div style="width: 100%"><iframe width="100%" height="600" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.com/maps?width=100%25&amp;height=600&amp;hl=en&amp;q=43.3136063,%2021.9349746+(My%20Business%20Name)&amp;t=&amp;z=14&amp;ie=UTF8&amp;iwloc=B&amp;output=embed"><a href="https://www.gps.ie/">gps devices</a></iframe></div>
											<p>Pogledaj mesto lokacije radnje!</p>
										</article>
									</div>
									
								</section>

							<!-- Section -->
								<section>
									<header class="major">
										<h2>Kontaktiraj nas</h2>
									</header>
									<p>Naši operateri vredno rade da bi vam omogućili što bolje iskustvo na Modex Moda plus stranici, dostupni smo vam svakoga dana od 09h-21h, Pozovite nas!</p>
									<ul class="contact">
										<li class="icon solid fa-envelope"><a href="#">modexmodaplus@gmail.com</a></li>
										<li class="icon solid fa-phone">+381 64 1239911</li>
										<li class="icon solid fa-home">posetite našu lokaciju u Duvaništu, u sklopu samog objekta super marketa Aman<br />
										Majakovskog BB, Niš 18000, Srbija.</li>
									</ul>
								</section>

						</div>
					</div>

			</div>

		<!-- Scripts -->
			<script src="assets/js/jquery.min.js"></script>
			<script src="assets/js/browser.min.js"></script>
			<script src="assets/js/breakpoints.min.js"></script>
			<script src="assets/js/util.js"></script>
			<script src="assets/js/main.js"></script>

	</body>
</html>