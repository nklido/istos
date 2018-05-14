<?php
$active = array('profile'=>'','register_accom'=>'','home'=>'','login'=>'','register_user'=>'');
$tmp = explode('/',$_SERVER['PHP_SELF']); //split on '/'
$filename = substr($tmp[count($tmp)-1],0,-4); //get last element and remove the .php extension
$active[$filename] = "class='active'"; //adding class active for html

echo '<div class="nav" id="navbar"><ul>';
if(isset($_SESSION['user'])){
		echo '<li><a href="logout.php">Logout</a></li>';
		echo '<li><a '.$active['profile'].' href="profile.php#profile_info">Profile</a></li>';
		echo '<li><a '.$active['register_accom'].' href="register_accom.php">Add accomodation</a></li>';
}else{
	  echo "<li><a ".$active['login']."  id='login' href='login.php'>Login</a></li>";
	  echo "<li><a ".$active['register_user']."  id='register_user' href='register_user.php'>Register</a></li>";
}
echo '<li><a '.$active['home'].' id="home" href="home.php">Home</a></li>';
echo "</ul></div><br/></br>";
?>
