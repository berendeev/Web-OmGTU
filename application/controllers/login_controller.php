<?php
require_once(APP_PATH.'application/dao/login_dao.php');

class LoginController extends Controller{
  private $login_dao = null;
  
   public function __construct()
   {
     $this->login_dao = new LoginDao();
   }
  
   
  
  public function index(){
      echo 'index login controller';
  }
  
  public function api_registration(){
     if(!array_key_exists('login', $_POST) && !array_key_exists('password', $_POST)){
      echo(json_encode([
        'status' => 400,
        'error' => 'login and password required!'
      ]));
      die();
    }
    
    $login = $_POST['login'];
    $pass = $_POST['password'];
      
    if(empty($login)){
      echo(json_encode([
        'status' => 400,
        'error' => 'login required!'
      ]));
      die();
    }else if(!preg_match('/^[A-Za-z]{3,10}$/',$login)){
      echo(json_encode([
        'status' => 400,
        'error' => 'login not valid'
      ]));
      die();
    }
    
     if(empty($pass)){
       echo(json_encode([
        'status' => 400,
        'error' => 'password required!'
      ]));
      die();
    }else if(!preg_match('/^[A-Za-z0-9]{6,12}$/',$pass)){
       echo(json_encode([
        'status' => 400,
        'error' => 'password not valid'
      ]));
       die();
    }

    $this->login_dao->insertClient($login, $pass);
    echo(json_encode([
        'status' => 200,
        'error' => ''
      ]));
  }
  
  public function api_login(){
    if(!array_key_exists('login', $_POST) && !array_key_exists('password', $_POST)){
      echo(json_encode([
        'status' => 400,
        'error' => 'login and password required!'
      ]));
      die();
    }
    
    $login = $_POST['login'];
    $pass = $_POST['password'];
    
    $res = $this->login_dao->check($login, $pass);
    $persoid = $res[0]['id'];
    echo $persoid;
    if($persoid > 0){
      $token = uniqid();
      $this->login_dao->makeSession($persoid, $token);
      
      setcookie('booksessiontoken', $token);
      echo(json_encode([
        'status' => 200,
        'error' => ''
      ]));
      die();
    } else {
        echo(json_encode([
          'status' => 400,
          'error' => 'Invalid login or password'
        ]));
        die();
      }
 
  }
  
  public function api_logout(){
     if(!array_key_exists('booksessiontoken', $_COOKIE)){
      echo(json_encode([
        'status' => 400,
        'error' => 'Bad token'
      ]));
      die();
    }
    
    $token = $_COOKIE['booksessiontoken'];
    $this->login_dao->deleteSession($token);
     echo(json_encode([
          'status' => 200,
          'error' => ''
        ]));
    die();
  }

 
  
}