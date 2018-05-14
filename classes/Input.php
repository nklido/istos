<?php
class Input {

	public static function postDataExist(){
		return (!empty($_POST)) ? true : false;
  	}

	public static function getPost($item){
		if(isset($_POST[$item])){
       		return $_POST[$item];
     	}
     	return '';
   	}

}
?>
