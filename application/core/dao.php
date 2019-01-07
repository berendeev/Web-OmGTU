<?php
class Dao{
  protected $db = null;
  
   public function __construct()
   {
     $this->db = DataBase::getInstance();
   }
  
  
}