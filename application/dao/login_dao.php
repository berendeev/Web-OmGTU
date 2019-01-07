<?php
class LoginDao extends Dao{
  
  public function __construct(){
     parent::__construct();
  }
  
  public function insertClient(string $login, string $pass){
    $sql = "INSERT INTO person (login, pass) VALUES (?, ?)";
    $res = $this->db->query($sql, [$login, $pass]);
    
  }
  
  public function check(string $login, string $pass){
    $sql = "SELECT id FROM person WHERE login = ? AND pass = ?";
    $result = $this->db->query($sql, [$login, $pass]);
    return $result;
  }
  
  public function makeSession(int $personid, string $token){
    $sql = 'INSERT INTO `session` (token, personid) VALUES (?, ?)';
    return $this->db->query($sql, [$token, $personid]);
  }
  
  public function deleteSession( string $token){
    $sql = 'DELETE FROM `session` WHERE token = ?';
    return $this->db->query($sql, [$token]);
  }
  
}
?>