<?php
session_start();
if(isset($_SESSION['userloggedin']) && $_SESSION['userloggedin'] == true) {
	header('Location: index.php');
}
include 'connect.php';

if (isset($_POST['submit'])) {

		$stmt = $db->prepare('SELECT * FROM users WHERE username = :username AND password = :password');  

   

	    $criteria = [
	        'username' => $_POST['username'],
	        'password' => md5($_POST['password']),
         
	    ];

	    $stmt->execute($criteria);
	    $row = $stmt->fetch();

      //Check they entered the correct username/password
      if ($_POST['username'] === $row['username'] && md5($_POST['password']) === $row['password']) {
            $_SESSION['userloggedin'] = true;
            $_SESSION['userid'] = $row['id'];
            header('Location: index.php');
      }
      //If they didn't, display an error message
      else { 
          echo "<h2> <label style='color:red;'> Username or Password incorrect.</label> </h2>" . '<a href="login.php"><b>Try again?</a> </b> <br> Else -> Create a new account clicking ->' . '<a href="register.php"><b> Registration form</a></b><br>' . ' Else -> <a href="index.php"><b>Home page</a></b>'; 
      }
}
else { //The submit button was not pressed, show the log-in form
?>
<link rel="stylesheet" type="text/css" href="css/admin.css" />
<form class="Popup-content animate" action="" method="POST">
    <div class="imgcontainer">
        <h1>User Panel</h1>
      <img src="images/avatar/avatar.png" alt="Avatar" class="avatar">
    </div>
    <div class="container">
      <label for="username"><b>Username</b></label>
      <input type="text" placeholder="Username" name="username" required>

      <label for="password"><b>Password</b></label>
      <input type="password" placeholder="Password" name="password" required>
     
      <button type="submit" name="submit">Login</button>
      
    </div>

  </form>
<?php
}