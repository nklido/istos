<?php
require('core/init.php');

if(!isset($_SESSION['user'])) {
  header('location:login.php');
}
?>

<!DOCTYPE html>
<html lang="el">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <link href="css/profile.css" rel="stylesheet" type="text/css">
  <link href="css/navigation.css" rel="stylesheet" type="text/css">
	<title>My profile</title>
</head>
<body>
  <?php include('navigation.php');?>
  <?php include('navigation_profile.php'); ?>

  <div class="profile_content">
    <div  id='profile_section'>
      <?php

        if(isset($_FILES['avatar'])){
          $vld = new Validation();
          $vld->check($_FILES,array(
            'avatar' => array(
              'file_extension'=> array('jpg','png'),
              'valid_mime'    => array('image/jpeg','image/png')
            )
          ));

          if($vld->passed()) {
            $from = $_FILES['avatar']['tmp_name'];
            $to   = 'pictures/avatars/'.$_SESSION['user'].'_'.escape($_FILES['avatar']['name']);
            if(!move_uploaded_file($from,$to)){
              echo 'error moving file!';
            }else{
              $usr = new User();
              $path = $usr->getAvatarPath($_SESSION['user_id']);
              if(isset($path)){
                if(strcmp($path,"pictures/avatars/generic-avatar.png") && strcmp($to,$path)){
                  unlink($path);
                }
              }
              $usr->updateAvatarById($_SESSION['user_id'],$to);
              $_SESSION['path_to_avatar'] = $to;
              header("Refresh:0");
            }

          }else{ //Validation not passed
            foreach($vld->errors() as $error) {
              echo "Error : {$error}</br>";
            }
          }
        }
        $usr = new User();
        $data = $usr->getUser(array('username','firstname','lastname','path_to_avatar','email'),'s',array('username' => $_SESSION['user']));
        $data = $data[0];

        echo '<table>';
        echo '<tr>
                <td colspan="2">
                  <img src="'.$data['path_to_avatar'].'"alt="Avatar">
                  <form enctype="multipart/form-data" action="#"  id="upload_form" method="POST">
                    <input type="file" name="avatar" id="file_input">
                    <button type="submit">submit</button>
                  <form>
                </td>
              </tr>';

        foreach($data as $key => $val) {
          if($key == "path_to_avatar") continue;
          echo '<tr>
                  <td width="150px">'.$key.'</td>
                  <td>'.$val.'</td>
                </tr>';
        }
        echo '</table>';
      ?>
    </div>
  </div>
  <hr>

	<div id="footer">
		<p>
		</p>
	</div>
</body>
</html>
