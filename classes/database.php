<?php
// Singleton design pattern
// connect to database only once
// use the same db insance everywhere
class Database{
  private static $_instance = null;
  private $_dbc,
          $_query,
          $_error=false,
          $_results,
          $_count=0;

  //private constructor
  private function __construct(){
    $this->_dbc  = new mysqli(Config::get('mysql/host'),
                        Config::get('mysql/username'),
                        Config::get('mysql/password'),
                        Config::get('mysql/db'));
    if ($this->_dbc->connect_error) {
        die('Connect Error (' . $mysqli->connect_errno . ') '. $mysqli->connect_error);
    }

  }

  public static function getInstance(){
    if(!isset(self::$_instance)){
      self::$_instance = new Database();
    }
    return self::$_instance;
  }

  public function query($sql,$type='',$params = array()){
    $this->_error = false;
    if($this->_query = $this->_dbc->prepare($sql)){
      if(count($params)){
        call_user_func_array(array($this->_query, "bind_param"),array_merge(array($type), $params));
      }
      if($this->_query->execute()){
          $this->_results = $this->_query->get_result() ?? NULL;
          $this->_count  = $this->_results->num_rows ?? NULL;
      }else{
        $this->_error = true;
      }

    }
  }//end query function

  /*
  insert syntax example:
  INSERT INTO table_name (column1, column2, column3, ...)
                    VALUES (value1, value2, value3, ...);
  */

  public function insert($table,$vals=array(),$type=''){
    if($this->tableExists($table)){
      if(count($vals)){
          $insert_query = 'INSERT INTO '.$table.' ('.implode(', ',array_keys($vals)).')';
          $insert_query .= ' VALUES ('.substr(str_repeat("?,",count($vals)),0,-1).');';
          $this->_query = $this->_dbc->prepare($insert_query);
          call_user_func_array(array($this->_query, "bind_param"),array_merge(array($type), $vals));
      }

      if(!($this->_query->execute())){
        $this->_error = true;
      }
    }
  }


  /*Check if a given talbe exists in database*/
  private function tableExists($table){
    $this->_results = $this->_dbc->query("SHOW TABLES LIKE '$table';");
    return $this->_results->num_rows>0?true:false;
  }

  public function getFirst(){
    if($this->_count>0)
      return $this->_results->fetch_array(MYSQLI_ASSOC);
  }

  public function results(){
    if($this->_count>0)
      return $this->_results;
  }

  public function getResultArray(){
    if($this->_count>0)
      return $this->_results->fetch_all(MYSQLI_ASSOC);
  }

  public function count(){
    return $this->_count;
  }
  public function error(){
    return $this->_error;
  }

  //call for debug purposes
  public function getErrorDescr(){
    return "Error description: " . mysqli_error($this->_dbc);
  }
}
?>
