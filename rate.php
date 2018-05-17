<?php
require('core/init.php');
if(isset($_SESSION['user'])){
  if(isset($_POST['data'])){
    // true to decode as associative array

    $user_id = $_SESSION['user_id'];
    $data = json_decode($_POST['data'],true);
    $_POST['rating']   = escape($data['rating']);
    $_POST['comment']  = escape($data['comment']) ?? ''; //try comment, if is null go with ''
    $_POST['accom_id'] = escape($data['accom_id']);
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
      $accom_id = $_POST['accom_id'];
      $rating   = $_POST['rating'];

      $db = Database::getInstance();
      $db->insert('ratings',array(
        'user_id'  => &$user_id,
        'accom_id' => &$accom_id,
        'rating'   => &$rating
      ),'iis');
      if(!$db->error()){
        echo 'rating registered';
      }else{
        echo $db->getErrorDescr();
      }
    }else{
      $vld->echoErrors();
    }
  }
}
?>
