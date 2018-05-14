<?php
require('core/init.php');

if(!isset($_SESSION['user'])) {
	header("Location:login.php");
}

//check if form is submitted
if(Input::postDataExist()) {
	$validation = new Validation();
  	$validation->check($_POST,array(
		'title' => array(
	      	'required'=>true,
	      	'min' => 2,
	      	'max' => 60
    	),
    	'location' => array(
	      	'required' => true,
	      	'min'      => 2,
	      	'max'      => 25
    	),
    	'description'  => array(
	      	'required' => true
    	),
    	'checkin' => array(
	      	'required'   => true,
	      	'valid_time' => true
    	),
    	'checkout' => array(
	      	'required'   => true,
	      	'valid_time' => true
	    ),
  ));

  if($validation->passed()) {
    $title       = escape($_POST['title']);
    $location    = escape($_POST['location']);
    $description = escape($_POST['description']);
    $checkin     = escape($_POST['checkin']);
    $checkout    = escape($_POST['checkout']);
    $user_id     = $_SESSION['user_id'];

    $accom = new Accommodation();
    $accom->createAccommodation(array(
              						'title'       => &$title,
                      				'location'    => &$location,
                      				'description' => &$description,
                      				'checkin'     => &$checkin,
                      				'checkout'    => &$checkout,
    								'user_id'     => &$user_id),
                    		   	'sssssi');
    header('Location:home.php');
    exit();
  }else{ //Validation not passed
    foreach($validation->errors() as $error) {
      echo "Error : {$error}</br>";
    }
  }
}
?>

<!DOCTYPE html>
<html lang="el">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  	<link href="css/form.css" rel="stylesheet" type="text/css">
	<link href="css/navigation.css" rel="stylesheet" type="text/css">
	<title>Register Accommodation</title>
</head>
<body>
  <?php include('navigation.php');?>
	<div id="accom" class="form_div">
		<h1>Register Accommodation</h1>
		<form action="#" method="POST" id="accom_form">
			<label class="required">Title </label>
			<input type="text" id="title" name="title" placeholder="Insert title here"
				value="<?php echo escape(Input::getPost('title'))?>" required>
      	</br></br>

			<label>Upload an image</label>
      	<br/>

      	<label class="required">Location </label>
			<input type="text" id="location" name="location" placeholder="Insert a valid location"
				value="<?php echo escape(Input::getPost('location'))?>" required>
 	 	</br>

      	<label>Description</label>
      	<textarea name="description" id="description" name="description" placeholder="Describe"
  			rows="4" cols="25"><?php echo escape(Input::getPost('description'))?>
      	</textarea>
      	</br>

      	<label  class="required">Checkin time</label>
			<input type="text" id="checkin" name="checkin" placeholder="Type valid check-in time"
				pattern="^([0-9]|0[0-9]|1[0-9]|2[0-3]):[0-5][0-9]$" 
				value="<?php echo escape(Input::getPost('checkin'))?>"required>
      	</br></br>

      	<label  class="required">Checkout time</label>
      	<input type="text" id="checkout" name="checkout" placeholder="Type valid check-out time"
      		pattern="^([0-9]|0[0-9]|1[0-9]|2[0-3]):[0-5][0-9]$" 
      		value="<?php echo escape(Input::getPost('checkout'))?>"required>
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
