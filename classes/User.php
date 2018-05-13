<?php
require_once('connectDB.php');

class User{
    private $_db;

    public function __construct(){
      $this->_db = database::getInstance();
    }

    function getUsers(){
        $dbcon = new DBConnection();
        $result = mysqli_query($dbcon->getdbconnection(), "SELECT * FROM users");
        $numOfUsers = mysqli_num_rows($result);
        if ($numOfUsers == 0) {
            echo 'No users';
        } else {
            while ($row = mysqli_fetch_array($result,MYSQLI_NUM)) {
                print_r($row);
            }
        }
    }
}


$users = new Users();
echo "<pre/>";print_r($users->getUsers());
?>
