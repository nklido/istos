<?php
class User{
  private $_db;

  public function __construct(){
    $this->_db = Database::getInstance();
  }

  function createUser($table,$values=array(),$type=''){
    $this->_db->insert($table,$values,$type);
    if($this->_db->error()){
      echo $this->_db->getErrorDescr();
      exit();
    }else{
      return true;
    }
  }
  function getUsers(){
    $this->_db->query('select * from users');
    if($this->_db->error()){
      echo $this->_db->getErrorDescr();
    }else{
      return $this->_db->getResultArray();
    }
  }

  function getUserById($id){
    $this->_db->query('select * from users where user_id = ?','d',array(&$id));
    if($this->_db->error()){
      echo $this->_db->getErrorDescr();
    }else{
      echo $this->_db->count();
      return $this->_db->getFirst();
    }
  }

  //specify which collumns, which equality condition
  function getUser($which,$type,$cond){
    //echo 'select '.implode(', ',$which).' from users where '.key($cond).' = '.$cond[key($cond)];
    $this->_db->query('select '.implode(', ',$which).' from users where '.key($cond).' = ?',$type,array(&$cond[key($cond)]));
    if($this->_db->error()){
      echo $this->_db->getErrorDescr();
    }else{
      return $this->_db->getResultArray();
    }
  }


  function getUserByUsername($user){
    $this->_db->query('select * from users where username = ?','s',array(&$user));
    if($this->_db->error()){
      echo $this->_db->getErrorDescr();
    }else{
      return $this->_db->getFirst();
    }
  }
}

?>
