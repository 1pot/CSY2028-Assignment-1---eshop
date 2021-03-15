<?php
session_start();

unset($_SESSION['loggedin']);

echo 'You are now logged out Go to 
<a href="admin.php">
Admin Panel</a>' . ' Or <a href="index.php">Home Page</a>';
