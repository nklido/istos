<?php
class Validation{
  private $_passed =false,
          $_errors =array(),
          $_dbc    = NULL;

  public function __construct(){
    $this->_dbc = database::getInstance();
  }

  // $source is either $_GET or $_POST
  public function check($source,$fields = array()){
    foreach($fields as $field => $rules){
      foreach($rules as $rule => $rule_value){
        //echo $field.' '.$rule.'must be ' .$value.'</br>';
        $value = $source[$field];
        if($rule === 'required' && empty($value)){
          $this->addError("{$field} is required");
        }else if(!empty($value)){
          switch($rule){
            case 'min': #checkng minimum length
              if(strlen($value)<$rule_value){
                $this->addError("{$field} minimum characters are {$rule_value}");
              }
              break;
            case 'max': #checkng maximum length
              if(strlen($value)>$rule_value){
                $this->addError("{$field} maximum characters are {$rule_value}");
              }
              break;
            case 'matches': #check if value of this field matches the value of the field specified by rule_value
              if($value != $source[$rule_value]){
                $this->addError("{$rule_value} does not match");
              }
              break;
            case 'unique':
              $this->_dbc->query("select count(*) as count from {$rule_value} where {$field}= ?",'s',array(&$value));
              if($this->_dbc->error()){
                echo 'Error executing query';
              }else{
                if($this->_dbc->getFirst()['count'] !== 0){
                  $this->addError("{$field}: {$value} already exists");
                }
              }
              break;
          }
        }
      }
    }
    if(empty($this->_errors)){
      $this->_passed = true;
    }
  }//end function check

  public function authenticate($source){
    $this->_dbc->query("select password as pw from users where username= ?",'s',array(&$source['username']));
    if($this->_dbc->error()){
      echo 'Error executing query';
      return false;
    }else{
      if($this->_dbc->getFirst()['pw'] === $source['password']){
        return true;
      }
    }
    return false;

  }

  private function addError($error){
    array_push($this->_errors,$error);
  }

  public function errors(){
    return $this->_errors;
  }

  public function passed(){
    return $this->_passed;
  }
}
?>
