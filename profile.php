<?php
include 'core/init.php';
include 'navigation.php';
if(!isset($_SESSION['user'])){
  header('location:login.php');
}
?>
<!DOCTYPE html>
<html lang="el">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <link href="css/profile.css" rel="stylesheet" type="text/css">
  <link href="css/navigation.css" rel="stylesheet" type="text/css">

  <script type="text/javascript" src="js/profile.js"></script>
	<title>My profile</title>
</head>
<body>
  <?php include_once 'navigation.php';?>

  <div class='nav' id='profile_nav'>
    <ul>
      <li><a class="active" id='profile_info'href='#profile_info'>Profile info</a></li>
      <li><a id='reservations' href='#reservations'>Reservations</a></li>
      <li><a id='accommodations' href='#accommodations'>My Accommodations</a></li>
      <li><a id='history' href='#history'>History</a></li>
    </ul>
	</div>
  <div id="profile_content">
    <div  class='profile_section' id="profile_info_content">
      <?php
        $usr = new User();
        $data = $usr->getUser(array('username','firstname','lastname','path_to_avatar','email'),'s',array('username' => $_SESSION['user']));
        $data = $data[0];

        echo '<table>';
        echo '<tr><td colspan="2"><img src="'.$data['path_to_avatar'].'"alt="Avatar" width="250" height="250"></td></tr>';
        foreach($data as $key => $val){
          if($key == "path_to_avatar") continue;
          echo '<tr>
                  <td width="150px">'.$key.'</td>
                  <td>'.$val.'</td>
                </tr>';
        }
        echo '</table>';
      ?>
      </table>
    </div>

    <!--
    <div class='profile_section' id="reservations_content">RESERVATIONS</div>
    <div class='profile_section' id="accommodations_content">Accommodations</div>
    <div class='profile_section' id="history_content">HISTORY</div>
  -->
  </div>

  <hr>
	<div id="footer">
		<p>
		</p>
	</div>
</body>
</html>
