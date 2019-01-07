<?php
class BaseDao{
  public static $db=null;
  public function __construct(){
    $db=DataBase::getDataBase();
  }
}


?>