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

  function getAccomByRentId($id) {
    $this->_db->query('select * from accommodations,bookings where rent_id = ? and accommodations.accom_id = bookings.accom_id','d',array(&$id));
    if($this->_db->error()) {
      echo $this->_db->getErrorDescr();
    }else{
      return $this->_db->getFirst();
    }
  }

  function completeBooking($rentid){
    $this->_db->query('update bookings set status="completed" where rent_id = ?  ','i',array(&$rentid));
    if($this->_db->error()) {
      echo $this->_db->getErrorDescr();
    }
  }

  function getAccomsByUserId($id) {
    $this->_db->query('select * from accommodations where user_id = ?','i',array(&$id));
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

  function updateRatings($rent_id,$rating){
    $accom = $this->getAccomByRentId($rent_id);
    $id = $accom['accom_id'];
    echo $id;
    $sum = $accom['votes'] * $accom['rating'];
    $votes = $accom['votes']+1;   //add votes by 1
    $newRating = ($sum+$rating)/($votes);     //calculate new average
    $this->_db->query("update accommodations set votes=? ,rating=?  where accom_id= ?",'idi',array(&$votes,&$newRating,&$id));
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

  function getRatingsById($accom_id){
    $this->_db->query(" SELECT users.username as user ,ratings.rating as rating,ratings.comment as comment
                        FROM accommodations,bookings,ratings,users
                        WHERE accommodations.accom_id= ?
                        AND   users.user_id     = bookings.user_id
                        AND   bookings.accom_id = accommodations.accom_id
                        AND   bookings.rent_id  = ratings.rent_id
                        AND   ratings.comment <>''",
                          'i',array(&$accom_id));
    if($this->_db->error()) {
      echo $this->_db->getErrorDescr();
    }else{
      return $this->_db->getResultArray();
    }
  }

  function getImagePath($id) {
    $this->_db->query('select path_to_image from accommodations where accom_id = ?','i',array(&$id));
    if($this->_db->error()) {
      echo $this->_db->getErrorDescr();
    }else{
      return $this->_db->getFirst()['path_to_image'];
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
