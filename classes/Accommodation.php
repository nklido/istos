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
    $this->_db->query('select * from accommodations where accom_id = ?','d',array(&$id));
    if($this->_db->error()) {
      echo $this->_db->getErrorDescr();
    }else{
      return $this->_db->getFirst();
    }
  }

  function getAccomsByUserId($id) {
    $this->_db->query('select * from accommodations where user_id = ?','d',array(&$id));
    if($this->_db->error()) {
      echo $this->_db->getErrorDescr();
    }else{
      return $this->_db->getResultArray();
    }
  }

  # create entry in bookings table
  function bookAccommodation($values=array(), $type='') {
    $this->_db->insert('bookings', $values, $type);
    if($this->_db->error()){
      throw new Exception($this->_db->getErrorDescr());
    }else{
      return true;
    }
  }

  function getBookedAccomsByUserId($id){
    $this->_db->query('select accommodations.*,bookings.* from accommodations,bookings,users where status="active"
                        and bookings.user_id = users.user_id
                        and accommodations.accom_id = bookings.accom_id
                        and users.user_id= ?','i',array(&$id));
    if($this->_db->error()) {
      echo $this->_db->getErrorDescr();
    }else{
      return $this->_db->getResultArray();
    }
  }

  function getBookingHistoryByUserId($id){
    $this->_db->query('select accommodations.*,bookings.*
              from accommodations,bookings,users
                where status="completed"
                and bookings.user_id = users.user_id
                and accommodations.accom_id = bookings.accom_id
                and users.user_id= ?','i',array(&$id));
    if($this->_db->error()) {
      echo $this->_db->getErrorDescr();
    }else{
      return $this->_db->getResultArray();
    }
  }

  function isAvailableAtDate($date,$id){
    $this->_db->query('select count(*) as count from bookings where accom_id = ? and
                                        STR_TO_DATE(?, "%Y-%m-%d") between checkin_date and checkout_date
                                                    and status="active"','is',array(&$id,&$date));
      if($this->_db->error()){
        echo $this->_db->getErrorDescr();
      }else{
        if($this->_db->getFirst()['count']==0){
            return true;
        }else{
            return false;
        }
      }
    }


  function updateImagebyId($id,$path){
    $this->_db->query("update accommodations set path_to_image=? where accom_id = ?",'sd',array(&$path,&$id));
    if($this->_db->error()) {
      echo $this->_db->getErrorDescr();
    }
  }

  function getExistingLocations(){
    $this->_db->query("SELECT location FROM accommodations group by location");
    if($this->_db->error()) {
      echo $this->_db->getErrorDescr();
    }else{
      return $this->_db->getResultArray();
    }
  }


  function getAccomByLocation($location) {
    $this->_db->query('select * from accommodations where location = ?','s',array(&$location));
    if($this->_db->error()) {
      echo $this->_db->getErrorDescr();
    }else{
      return $this->_db->getResultArray();
    }
  }
}
?>
