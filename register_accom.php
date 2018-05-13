<?php
include 'core/init.php';
if(!isset($_SESSION['user'])){
    header("Location:login.php");
}
if(Input::postDataExist()){
}
?>
<!DOCTYPE html>
<html lang="el">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <link href='navigation.css' rel="stylesheet" type="text/css">
	<title>Register Accommodation</title>
</head>
<body>
  <?php include 'navigation.php';?>
	<div id="accom">
		<h1>Register Accommodation</h1>
    <a href='home.php'>Back to home</a>
		<form action="#" method="POST" id="accom_form">

			<label  class="required">Title </label>
			<input type="text" id="title" name="title" value="<?php echo escape(Input::getPost('title'))?>" required>
      </br></br>

			<label>Upload an image</label>
      <br/>


      <label  class="required">Location </label>
			<input type="text" id="location" name="location" value="<?php echo escape(Input::getPost('location'))?>" required>
      </br>

      <label>Description</label>
      <textarea name="description" id="description" name="description" rows="4" cols="50"><?php echo escape(Input::getPost('description'))?>
      </textarea>
      </br>

      <label  class="required">Checkin time</label>
			<input type="text" id="checkin" name="checkin" pattern="^([0-9]|0[0-9]|1[0-9]|2[0-3]):[0-5][0-9]$" value="<?php echo escape(Input::getPost('checkin'))?>"required>
      </br></br>

      <label  class="required">Checkout time</label>
      <input type="text" id="checkout" name="checkout" pattern="^([0-9]|0[0-9]|1[0-9]|2[0-3]):[0-5][0-9]$" value="<?php echo escape(Input::getPost('checkout'))?>"required>
      </br></br>

			<button type="submit" value ="register_accom">Add accomodation</button>
		</form>
	</div>
	<div id="footer">
		<p>
		</p>
	</div>
</body>
</html>
