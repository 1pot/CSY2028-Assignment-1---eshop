<?php
session_start();

unset($_SESSION['userloggedin']);
unset($_SESSION['userid']);

header('Location: index.php');