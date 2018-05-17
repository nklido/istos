<?php
$active = array('profile'=>'','bookings'=>'','profile_accom'=>'','history'=>'');
$tmp = explode('/',$_SERVER['PHP_SELF']); //split on '/'
$filename = substr($tmp[count($tmp)-1],0,-4); //get last element and remove the .php extension
$active[$filename] = 'class="active"';

echo '<div class="nav" id="profile_nav"><ul>';
echo  '<li><a '.$active['profile'].'" id="profile_info" href="profile.php">Profile info</a></li>';
echo '<li><a '.$active['bookings'].' id="bookings" href="bookings.php">Bookings</a></li>';
echo '<li><a '.$active['profile_accom'].' id="profile_accom" href="profile_accom.php">My Accommodations</a></li>';
echo '<li><a '.$active['history'].' id="history" href="history.php">History</a></li>';
echo "</ul></div>";
?>
