<?php
require('core/init.php');

$userLoggedin  = false;
$userOwnsAccom = false;

if(isset($_GET['id'])){ //id parameter specifies which accommodation to display
  $accom = new Accommodation();
  $accom_id = escape($_GET['id']);
  $data = $accom->getAccomById($accom_id);
  if($data == null){ //check if exists, else redirect to 404
    header('location:includes/404.php');
  }


  if(isset($_SESSION['user'])){ //Evaluate if user is loggedin, if true check if he owns the current accommodation (defaults are false)
    $userLoggedin = true;
    if($_SESSION['user_id'] == $data['user_id']){
      $userOwnsAccom = true;
    }
  }

  if(isset($_POST['book_form']) && !$userOwnsAccom){
    if(!$userLoggedin){
      header('location:login.php');
    }else{ //User loggedin and doesn't own this Accom
      $vld = new Validation();
      $vld->check($_POST,array(
        'checkin_date'     => array(
          'valid_date'     => true,
          'before_date'    => 'checkout_date',
          'available_date' => array($accom,$accom_id),
          'required' => true
        ),
        'checkout_date' => array(
          'valid_date' => true,
          'available_date' => array($accom,$accom_id),
          'required' => true
        )
      ));

      if($vld->passed()){
        $checkin  = escape($_POST['checkin_date']);
        $checkout = escape($_POST['checkout_date']);
        $uid      = $_SESSION['user_id'];


        $added = $accom->bookAccommodation(array(
          'user_id'       =>&$uid,                  // from session
          'accom_id'      =>&$accom_id,                  // specified by get.
          'checkin_date'  =>&$checkin,
          'checkout_date' =>&$checkout
        ),'iiss');


      }else{
        $vld->alertErrors();
      }
    }
  }
}else{//IF id is not set there is nothing to display at accommodation.php ---> redirect to home
  header('location:home.php');
}
?>
<!DOCTYPE html>
<html lang="el">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<link href="css/navigation.css" rel="stylesheet" type="text/css">
  <link href="css/accommodation.css" rel="stylesheet" type="text/css">
	<title>Accomodations</title>
</head>
<body>
  <?php include('navigation.php');?>
  <div class="main_div">
		<div class="content">
<?php
      #echo "USER LOGGED IN : ".var_dump($userLoggedin).'</br>';
      #echo "USER OWN Accommodation : ".var_dump($userOwnsAccom);
      if(isset($_FILES['image']) && $userOwnsAccom){
        $vld = new Validation();
        $vld->check($_FILES,array(
          'image' => array(
            'file_extension'=> array('jpg','png'),
            'valid_mime'    => array('image/jpeg','image/png')
          )
        ));
        if($vld->passed()) {
          $from = $_FILES['image']['tmp_name'];
          $to   = 'pictures/accommodations/'.$_SESSION['user'].'_'.escape($_FILES['image']['name']);
          if(!move_uploaded_file($from,$to)){
            echo 'error moving file!';
          }else{
            $accom = new Accommodation();

            $path = $accom->getImagePath($data['accom_id']);
            if(isset($path)){
              if(strcmp($path,"pictures/accommodations/not_available.jpg") && strcmp($to,$path)){
                unlink($path);
              }
            }
            $accom->updateImageById($data['accom_id'],$to);
            $data['path_to_image']=$to;
          }
        }else{ //Validation not passed
          foreach($vld->errors() as $error) {
            echo "Error : {$error}</br>";
          }
        }
      }

      $rent_form = '';
      $upload_form='';
      if($userOwnsAccom){ //Only user who owns the accommodation can see upload file form.
        $upload_form =
        '<form enctype="multipart/form-data" id="upload_form" method="POST">
            <input type="file" name="image" id="file_input">
            <button type="submit">submit</button>
         </form>';
      }else{ //Only users who don't own  the accommodation can book it.
        $rent_form =
          '<div id="booking_form">
          <h2>Book this accommodation</h2>
          <form method="POST" action="">
            <label>Checking Date
            <input type="date" id="checkin_date" name="checkin_date" required></label></br>
            <label>Checkout Date
            <input type="date" id="checkout_date" name="checkout_date" required></label></br>
            <button type="submit" name="book_form">Submit</button>
          </form></div>';
      }
      echo $rent_form;
      $comment_section = '<div id="comment_section"><h2>Comments</h2>';
      $accom = new Accommodation();
      $comments = $accom->getRatingsById($data['accom_id']);
      if(!empty($comments)){
        foreach($comments as $i => $rating){
          $user_rating = round($rating['rating']);
          $user_stars ='';
          for($i=5;$i>=1;$i--){
            if($user_rating==$i){
              $user_stars.='<a class="registered"></a>';
            }else{
              $user_stars.='<a></a>';
            }
          }
          $comment_section.="<div><b>User {$rating['user']} wrote</b></br><div class='stars'>{$user_stars}</div></br><i>{$rating['comment']}</i></div></br>";
        }
      }
      $comment_section.='</div>';

      $rating = round($data['rating']);
      $stars ='';
      for($i=5;$i>=1;$i--){
        if($rating==$i){
          $stars.='<a class="registered"></a>';
        }else{
          $stars.='<a></a>';
        }
      }
      $str = <<< EOR
      <table>
        <tr>
          <th>{$data['title']}</th>
        </tr>
        <tr>
          <td>
            <img class='accom_img' src="{$data['path_to_image']}" alt="Avatar" width='256' heght='256'>
            {$upload_form}
          </td>
        </tr>
        <tr>
          <td><div class='stars'>{$stars}</div></td>
        </tr>
        <tr>
          <td>Votes : {$data['votes']} </td>
        <tr>
        <tr>
          <td>{$data['description']}</td>
        </tr>
        <tr>
          <td>{$data['location']}</td>
        </tr>
        <tr>
          <td>Checkin time : {$data['checkin']}</td>
        </tr>
        <tr>
          <td>Checkout time: {$data['checkout']}</td>
        </tr>
      </table>
EOR;
      echo $str;

      echo $comment_section;
?>
    </div>
  </div>
	<div id="footer">
		<p>
		</p>
	</div>
</body>
<?php
if(isset($added)) echo "<script language='javascript'>alert('Booking successfully registered!!!');</script>";
?>
</html>
