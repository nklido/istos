<?php
include 'core/init.php';

if(isset($_SESSION['user'])){
    header("Location:home.php");
 }

if(Input::postDataExist()){
  $validation = new Validation();
  $validation->check($_POST,array(
    'username' => array(
      'required'=>true,
      'min' =>4,
      'max' =>16,
    ),

    'password' => array(
      'required' => true,
      'min'     => 6
    )
  ));

  if($validation->authenticate($_POST)){
    echo "success!!";
    $_SESSION['user']=$_POST['username'];
    echo '<script type="text/javascript"> window.open("home.php","_self");</script>';
  }else{
    echo 'Username or password are incorrect!';
  }
}
?>
<!DOCTYPE html>
<html lang="el">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<link href="ask2.css" rel="stylesheet" type="text/css">
	<title>Login</title>
</head>
<body>
  <?php include 'navigation.php';?>
	<div id="login">
		<h1>Login</h1>
		<form action="#" method="POST" id="login_form">

			<label  class="required">Username</label>
			<input type="text" id="username" name="username" value="<?php echo escape(Input::getPost('username'))?>" required>
      </br></br>

			<label  class="required">Password</label>
			<input type="password" placeholder="type password"  name ="password" required>
      <br/><br/>
			<button type="submit" value ="Login">Submit</button>
		</form>
	</div>
	<div id="footer">
		<p>
			<!-- credits και πληροφορίες copyright -->
		</p>
	</div>
</body>
</html>
