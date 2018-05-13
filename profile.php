<?php
include 'core/init.php';
include 'navigation.php';
if(isset($_SESSION['user'])){
  ('location:login.php');
}


?>
<!DOCTYPE html>
<html lang="el">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>My profile</title>
</head>
<body>
  <?php include 'navigation.php';?>
	<div id="accom">
		<?php echo "Hello my bro {$_SESSION['user']}"; ?>

	</div>
	<div id="footer">
		<p>
		</p>
	</div>
</body>
</html>
