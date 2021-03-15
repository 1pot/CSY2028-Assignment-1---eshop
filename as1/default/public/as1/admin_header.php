<?php
session_start();
if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] == false) {
  header('Location: admin.php');
}
include 'connect.php';
include 'functions.php'
?>

<!DOCTYPE html>
<html>
	<head>
		<title>ibuy Auctions</title>
		 <meta charset="UTF-8" />
		 <link rel="stylesheet" href="css/admin_panel_dashboard.css" />
	</head>

	<body>

<div class="wrapper">

  <nav>
	
    <header>
      <span></span> Admin Mode 
      <a></a>
    </header>

    <ul>
      <li><span>Categories</span></li>
      <li><a href="dashboard.php">Dashboard</a></li>
      <li><a href="categories.php">List Categories</a></li>
      <li><span>Other</span></li>
      <li><a>Non Functional</a></li>
      <li><a>Non Functional</a></li>
      <li><a href="adminlogout.php">Logout</a></li>
    </ul>

  </nav>

