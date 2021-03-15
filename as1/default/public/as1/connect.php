<?php 
$server = 'v.je';
$username = 'student';
$password = 'student';

//The name of the schema we created earlier in MySQL workbench
//If this schema does not exist you will get an error!
try {
$schema = 'csy2028';
$db = new PDO('mysql:dbname=' . $schema . ';host=' . $server, $username, $password,
[ PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
//echo 'connected';
//var_dump($server,$username,$password);
}
	catch (Exception $e){
		echo 'could not connect.';
		exit;
	}

?>