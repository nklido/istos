<?php
echo '<link href="css/navigation.css" rel="stylesheet" type="text/css">';
echo '<div id="navbar"><ul>';
echo '<li><a href="home.php">Home</a></li>';
if(isset($_SESSION['user'])){
		echo '<li><a href="register_accom.php">Add accomodation</a></li>';
		echo '<li><a href="profile.php">Profile</a></li>';
		echo '<li><a href="logout.php">Logout</a></li>';
}else{
	  echo "<li><a href='login.php'>Login</a></li>";
	  echo "<li><a href='register_user.php'>Register</a></li>";
}
echo "</ul></div><br/>";
?>
