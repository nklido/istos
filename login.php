<?php
require('core/init.php');

if(isset($_SESSION['user'])) {
  header('Location:home.php');
}

if(Input::postDataExist()) {
  $validation = new Validation();
  $validation->check($_POST,array(
      'username' => array(
        'required' => true,
        'min'      => 4,
        'max'      => 16,
    ),
      'password' => array(
        'required' => true,
        'min'      => 6
    )
  ));

  if($validation->authenticate($_POST)) {
    $user = new User();
    $user_data = $user->getUserByUsername(escape($_POST['username']));
    $_SESSION['user']           = $_POST['username'];
    $_SESSION['user_id']        = $user_data['user_id'];
    $_SESSION['path_to_avatar'] = $user_data['path_to_avatar'];
    $_SESSION['firstname']      = $user_data['firstname'];
    $_SESSION['lastname']       = $user_data['lastname'];

    echo '<script type="text/javascript"> window.open("home.php","_self");</script>';
  }else{
    //$validation->alertErrors();
    echo '<script>alert("Username or password are incorrect!")</script>';
  }
}
?>

<!DOCTYPE html>
<html lang="el">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<link href="css/form.css" rel="stylesheet" type="text/css">
  <link href="css/navigation.css" rel="stylesheet" type="text/css">
	<title>Login</title>
</head>
<body>
  <?php include('navigation.php');?>
	<div id="login" class="form_div">
		<h1>Login</h1>
		<form action="#" method="POST" id="login_form">

			<label class="required">Username</label>
			<input type="text" id="username" name="username"
       placeholder="Type your username"
       value="<?php echo escape(Input::getPost('username'));?>" required>
      </br></br>

			<label class="required">Password</label>
			<input type="password" placeholder="Type your password"  name ="password" required>
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
