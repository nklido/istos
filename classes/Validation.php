<?php
class Validation {

  private $_passed = false,
          $_errors = array(),
          $_dbc    = NULL;

  public function __construct() {
    $this->_dbc = Database::getInstance();
  }

  // $source is either $_GET or $_POST
  public function check($source, $fields = array()) {
    foreach($fields as $field => $rules) {
      foreach($rules as $rule => $rule_value) {
        //echo $field.' '.$rule.'must be ' .$value.'</br>';
        $value = $source[$field];
        if($rule === 'required' && empty($value)) {
          $this->addError("{$field} is required.");
        }else if(!empty($value)){
          switch($rule){
            case 'min': #checkng minimum length
              if(strlen($value)<$rule_value){
                $this->addError("{$field} minimum characters are {$rule_value}.");
              }
              break;
            case 'max': #checking maximum length
              if(strlen($value)>$rule_value) {
                $this->addError("{$field} maximum characters are {$rule_value}.");
              }
              break;
            case 'matches': #check if value of this field matches the value of the field specified by rule_value
              if($value != $source[$rule_value]) {
                $this->addError("{$rule_value} does not match.");
              }
              break;
            case 'valid_time': #check if value of this field is in a valid time format e.g. 00:00 - 23:59
              if(!preg_match("#([0-1]{1}[0-9]{1}|[2]{1}[0-3]{1}):[0-5]{1}[0-9]{1}#", $value)) {
                $this->addError("Not valid time format.");
              }
              break;
            case 'valid_date': # check if value of this field is a valid date -->
                               # using builtin php function checkdate(int $month,int $day,int $year)
                               # also in-order to be valid, it must be greater than current date
              $date = explode('-',$value);
              $year   = $date[0];
              $month  = $date[1];
              $day    = $date[2];
              if(!checkdate($month,$day,$year)){
                $this->addError("{$field} is not a valid date.");
                break;
              }else{ //if it's valid date type, check if it's greater than current date(!this may change into different rule)
                if($value < date("Y-m-d")){
                  $this->addError("{$value} is in the past.");
                }
              }
              break;
            case 'before_date':# check if the date given is before the value of the field specified by $rule_value
              if(!($value<$source[$rule_value])){
                $this->addError("{$rule_value} should be after {$field}.");
              }
              break;
            case 'available_date': # query db, expects rule value to be an array(instance
                                   # of class that implements isAvailableAtDate() method
                                   # ,primary key)
              $obj = $rule_value[0];
              $pk  = $rule_value[1];
              if(!$obj->isAvailableAtDate($value,$pk)){
                $this->addError("{$field} is not available.");
              }
              break;
            case 'valid_mail': #check if value of this field is a valid mail
              if(!filter_var($value, FILTER_VALIDATE_EMAIL)) {
                $this->addError("Not valid e-mail format.");
              }
              break;
            case 'unique':
              $this->_dbc->query("select count(*) as count from {$rule_value} where {$field}= ?",'s',array(&$value));
              if($this->_dbc->error()) {
                echo 'Error executing query.';
              }else{
                if($this->_dbc->getFirst()['count'] !== 0) {
                  $this->addError("{$field}: {$value} already exists.");
                }
              }
              break;
            case 'file_extension': # expects rule value to be an array of valid file extensions

              $name = explode(".",$name = $source[$field]["name"]);
              $extension = end($name);
              if(!in_array($extension,$rule_value)){
                $this->addError("{$field} has an invalid extension : {$extension}.");
              }
            break;
            case 'valid_mime':   # exprects rule value to be an array of valid mime types
              if(!in_array($source[$field]['type'],$rule_value)){
                $this->addError("{$field} has an invalid mime type: {$source[$field]['type']}.");
              }
              break;
            case 'enum': #expects rule_value to be an array of valid enums
              if(!in_array($value,$rule_value)){
                $this->addError("{$field} value is inappropriate");
              }
            break;
          }
        }
      }
    }

    if(empty($this->_errors)) {
      $this->_passed = true;
    }
  }//end function check

  public function authenticate($source) {
    $this->_dbc->query("select password as pw from users where username= ?",'s',array(&$source['username']));
    if($this->_dbc->error()) {
      echo 'Error executing query';
      return false;
    }else{
      $tmp_pass = $source['password'];
      $stored_hash = $this->_dbc->getFirst()['pw'];
      // Use verify() from class Password to convert and compare with stored hash
      if(Password::verify($tmp_pass, $stored_hash)) {
        return true;
      }
    }
    return false;
  }

  private function addError($error) {
    array_push($this->_errors,$error);
  }

  public function errors() {
    return $this->_errors;
  }

  public function echoErrors(){
    foreach($this->_errors as $error) {
      echo "Error : {$error}</br>";
    }
  }

  public function alertErrors(){
    $error_msg = implode("\\n",$this->_errors);
    echo "<script>alert('$error_msg');</script>";

  }

  public function passed() {
    return $this->_passed;
  }

}
?>
