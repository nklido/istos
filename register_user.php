<?php
require_once 'core/init.php';
//check if form is submitted
if(Input::postDataExist()){
  $validation = new Validation();
  $validation->check($_POST,array(
    'username' => array(
      'required'=>true,
      'min' =>4,
      'max' =>16,
      'unique' => 'users'
    ),

    'password' => array(
      'required' => true,
      'min'     => 6
    ),
    'password_again' => array(
      'required' => true,
      'matches'  => 'password'
    ),
    'firstname' => array(
      'required'=>true,
      'min' =>2,
      'max' =>25,
    ),
    'lastname' => array(
      'required'=>true,
      'min' =>2,
      'max' =>25,
    ),
    'email' => array(
      'unique' => 'users',
      'required' =>true
    ),
  ));
  if($validation->passed()){
    $user  = escape($_POST['username']);
    $pass  = escape($_POST['password']);
    $first = escape($_POST['firstname']);
    $last  = escape($_POST['lastname']);
    $mail  = escape($_POST['email']);

    $usr = new User();
    $usr->createUser('users',array(
                    'username'=>&$user,
                    'password'=>&$pass,
                    'firstname'=>&$first,
                    'lastname'=>&$last,
                    'email' =>&$mail),'sssss');
    header('Location:login.php');
    exit();

  }else{ //Validation not passed
    foreach($validation->errors() as $error){
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
	<title>Registration form</title>
</head>
<body>
  <?php include 'navigation.php';?>
	<div id="registration" class='form_div'>
		<h1>Registration</h1>
		<form action="#" method="POST" id="registration_form">

			<label for="username" class="required">Username</label>
			<input type="text" placeholder="e.g. Nikos1234" id="username" name="username" value="<?php echo escape(Input::getPost('username'))?>" required>
      </br></br>

			<label class="required">Choose password</label>
			<input type="password" placeholder="type password"  name ="password"required>

      <label class="required">Re enter password</label>
  		<input type="password" placeholder="re-enter password"  name ="password_again"required>
			<br>

			<label class="required">First name</label>
			<input type="text" placeholder="type your first name" name="firstname" value="<?php echo escape(Input::getPost('firstname'))?>"  required>

			<label class="required">Last name</label>
			<input type="text" placeholder="type your last name"  name="lastname" value="<?php echo escape(Input::getPost('lastname'))?>"required>

			<label class="required">
				Email
			</label>
			<input type="text" placeholder="e.g. example@yourmail.com" pattern=".*@.*" name ="email" value="<?php echo escape(Input::getPost('email'))?>"required>
			<br>
			<br>
			<button type="submit" value ="register">Submit</button>
		</form>
	</div>
	<div id="footer">
		<p>
			<!-- credits και πληροφορίες copyright -->
		</p>
	</div>
</body>
</html>
