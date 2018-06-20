<?php
require('core/init.php');

if(isset($_POST['rentid'])){

  $accom = new Accommodation();
  $rent_id = $_POST['rentid'];


  if(isset($_SESSION['user'])){ //Evaluate if user is loggedin, if true check if he owns the current accommodation (defaults are false)
    $accom->completeBooking($rent_id);
  }


}
header("location:profile_accom.php");
?>
