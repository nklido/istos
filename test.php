<?php
include 'core/init.php';

$db = database::getInstance();

$array = array("username","password");



$user = 'nik';
$pass = 'dddd';
$db->insert("users",array("username","password"),'ss',array(&$user,&$pass));
if($db->error()){
    print_r($db->error());
}
?>
