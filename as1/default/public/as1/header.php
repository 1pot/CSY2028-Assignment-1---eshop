<?php 
session_start();
include 'connect.php';
include 'functions.php';
$userloggedin = false;
if(isset($_SESSION['userloggedin']) && $_SESSION['userloggedin'] == true) {
	$userloggedin = true;
}
?>

<!DOCTYPE html>
<html>
	<head>
		<title>ibuy Auctions</title>
		 <meta charset="UTF-8" />
		<link rel="stylesheet" type="text/css" href="css/ibuy.css" />
	
	</head>

	<body>


		<header>
			<h1><span class="i">i</span><span class="b">b</span><span class="u">u</span><span class="y">y</span></h1>

			<form action="#">
				<input type="text" name="search" placeholder="Search for anything" />
				<input type="submit" name="submit" value="Search" />
			</form>
			<div style="display: block; float: right;">
				<?php if($userloggedin) { ?>
				<a href="logout.php">Logout</a> | <a href="auctions.php">Auctions</a>
				<?php } else { ?>
				<a href="register.php">Register</a> | <a href="login.php">Login</a>
				<?php } ?>
			</div>
		</header>

		<nav>
			<ul>
				<li><a href="index.php">Home</a></li>
				<?php foreach(getCategories() as $cat) { ?>
					<li><a href="category_products.php?catid=<?=$cat['id']?>"><?=$cat['name']?></a></li>
				<?php } ?>
				<!--<li><a href="#">Electronics</a></li>
				<li><a href="#">Fashion</a></li>
				<li><a href="#">Sport</a></li>
				<li><a href="#">Health</a></li>
				<li><a href="#">Toys</a></li>
				<li><a href="#">Motors</a></li>
				<li><a href="#">More</a></li>-->
			</ul>
		</nav>
		<img src="images/randombanner.php" alt="Banner" />
		<main>
