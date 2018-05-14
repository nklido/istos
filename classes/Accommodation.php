<?php
class Accommodation {
  private $_db;

  public function __construct() {
    $this->_db = Database::getInstance();
  }

  function createAccommodation($values=array(), $type='') {
    $this->_db->insert('accommodations', $values, $type);
    if($this->_db->error()) {
      echo $this->_db->getErrorDescr();
    }else{
      return true;
    }
  }

  function getAccommodations() {
    $this->_db->query('select * from accommodations');
    if($this->_db->error()) {
      echo $this->_db->getErrorDescr();
    }else{
      return $this->_db->getResultArray();
    }
  }

  function getAccomById($id) {
    $this->_db->query('select * from accommodations where user_id = ?','d',array(&$id));
    if($this->_db->error()) {
      echo $this->_db->getErrorDescr();
    }else{
      echo $this->_db->count();
      return $this->_db->getFirst();
    }
  }

  //specify which collumns, which equality condition
  function getUser($which, $type, $cond) {
    //echo 'select '.implode(', ',$which).' from accommodations where '.key($cond).' = '.$cond[key($cond)];
    $this->_db->query('select '.implode(', ',$which).' from accommodations where '.key($cond).' = ?',$type,array(&$cond[key($cond)]));
    if($this->_db->error()) {
      echo $this->_db->getErrorDescr();
    }else{
      return $this->_db->getResultArray();
    }
  }

  function getAccomByLocation($location) {
    $this->_db->query('select * from accommodations where username = ?','s',array(&$location));
    if($this->_db->error()) {
      echo $this->_db->getErrorDescr();
    }else{
      return $this->_db->getFirst();
    }
  }
}
?>
