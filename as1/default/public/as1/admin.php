<?php
session_start();
if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
	header('Location: dashboard.php');
}
include 'connect.php';

if (isset($_POST['submit'])) {

		$stmt = $db->prepare('SELECT * FROM admin WHERE username = :username AND password = :password');  

	    $criteria = [
	        'username' => $_POST['username'],
	        'password' => $_POST['password'],
	    ];

	    $stmt->execute($criteria);
	    $row = $stmt->fetch();

        //Check they entered the correct username/password
        if ($_POST['username'] === $row['username'] && $_POST['password'] === $row['password']) {
              $_SESSION['loggedin'] = true;
                header('Location: dashboard.php');
        }
        //If they didn't, display an error message
        else { 
                echo "<h2> <label style='color:red;'> Username or Password incorrect.</label> </h2>" . '<a href="admin.php"><b>Try again?</a></b> <br> Else Go to ->' . '<a href="index.php"><b> Home Page</a></b>'; 
        }
}
else { //The submit button was not pressed, show the log-in form
?>
<link rel="stylesheet" type="text/css" href="css/admin.css" />
<form class="Popup-content animate" action="admin.php" method="POST">
    <div class="imgcontainer">
        <h1>Admin Panel</h1>
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