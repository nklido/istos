<?php
require('core/init.php');
if(isset($_SESSION['user'])){
  if(isset($_POST['data'])){
    // true to decode as associative array

    $user_id = $_SESSION['user_id'];
    $data = json_decode($_POST['data'],true);
    $_POST['rating']   = escape($data['rating']);
    $_POST['comment']  = escape($data['comment']) ?? ''; //try comment, if is null go with ''
    $_POST['rent_id'] = escape($data['rent_id']);
    $vld = new Validation();
    $vld->check($_POST,array(
      'rating' => array(
        'required' => true,
        'enum'     => array(1,2,3,4,5)
      ),
      'comment' => array(
        'max'   => 150
      )
    ));
    if($vld->passed()){
      $comment  = $_POST['comment'];
      $rent_id =  $_POST['rent_id'];
      $rating   = $_POST['rating'];

      $db = Database::getInstance();
      $db->insert('ratings',array(
        'rent_id'  => &$rent_id,
        'rating'   => &$rating
      ),'is');
      if(!$db->error()){
        $accmdb = new Accommodation();
        $accmdb->updateRatings($rent_id,$rating);
        echo 'ok';
      }else{
        echo -1;
        //echo $db->getErrorDescr();
      }
    }else{ //
      $vld->echoErrors();
    }
  }
}
?>
