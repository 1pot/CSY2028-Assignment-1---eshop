<?php
session_start();
if(isset($_SESSION['userloggedin']) && $_SESSION['userloggedin'] == true) {
	header('Location: index.php');
}
include 'connect.php';

if (isset($_POST['submit'])) {

		$stmt = $db->prepare('Insert into users set username = :username , password = :password'); 

   

	    $criteria = [
	        'username' => $_POST['username'],
	        'password' => md5($_POST['password']),
          

	    ];

	    $stmt->execute($criteria);

      header('Location: login.php');
}
else { //The submit button was not pressed, show the log-in form
?>
<link rel="stylesheet" type="text/css" href="css/admin.css" />
<form class="Popup-content animate" action="" method="POST">
    <div class="imgcontainer">
        <h1>Register</h1>
      <img src="images/avatar/avatar.png" alt="Avatar" class="avatar">
    </div>
    <div class="container">
      <label for="username"><b>Username</b></label>
      <input type="text" placeholder="Username" name="username" required>

      <label for="password"><b>Password</b></label>
      <input type="password" placeholder="Password" name="password" required>
     
      <button type="submit" name="submit">Register</button>
      
    </div>

  </form>
<?php
}