<?php
require_once(APP_PATH.'application/dao/book_dao.php');
class BookController extends Controller{
   private $book_dao = null;
  
   public function __construct()
   {
     $this->book_dao = new BookDao();
   }
  
  public function index(){
    die();
  }
  
  public function addBook_api(){
     if(!array_key_exists('title', $_POST) && !array_key_exists('body', $_POST)){
      echo(json_encode([
        'status' => 400,
        'error' => 'title and body of the book required!'
      ]));
      die();
    }
    
    $picture = null;
    if(!array_key_exists('picture', $_POST)){
      $picture = $_POST['picture'];
    }
    
    $title = $_POST['title'];
    $body = $_POST['body'];
    
    
    if(empty($title)){
       echo(json_encode([
        'status' => 400,
        'error' => 'title required!'
      ]));
      die();
    }
    if(empty($body)){
       echo(json_encode([
        'status' => 400,
        'error' => 'body required!'
      ]));
      die();
    }
   
    $this->book_dao->addBook($title, $body, $picture);
     echo(json_encode([
        'status' => 200,
        'error' => ''
      ]));
  }
  
  public function getBooks_api(){
    if(!array_key_exists('bookid', $_GET)){
      $res = $this->book_dao->getAllBooks();
      echo json_encode($res);
      die();
    }
    
    $bookid = $_GET['bookid'];
    $res = $this->book_dao->getBookById($bookid);
    echo json_encode($res);
    die();
  }
  
  public function updateBook_api(){
    if(!array_key_exists('bookid', $_GET)){
       echo(json_encode([
        'status' => 400,
        'error' => 'bookid required!'
      ]));
    }
    $bookid = $_GET['bookid'];

    parse_str(file_get_contents("php://input"), $post_vars);
    if(!array_key_exists('title', $post_vars) && !array_key_exists('body', $post_vars) && !array_key_exists('picture', $post_vars)){
      echo(json_encode([
        'status' => 400,
        'error' => 'data required!'
      ]));
      die();
    }
      
    $title = $post_vars['title'];
    $body = $post_vars['body'];
    $picture = $post_vars['picture'];
    
    $this->book_dao->updateBook($bookid, $title, $body, $picture);
    echo(json_encode([
        'status' => 200,
        'error' => ''
      ]));
    die();
  }
  
  public function deleteBook_api(){
      if(!array_key_exists('bookid', $_GET)){
       echo(json_encode([
        'status' => 400,
        'error' => 'bookid required!'
      ]));
    }
    $bookid = $_GET['bookid'];
    
    $this->book_dao->deleteBook($bookid);
    echo(json_encode([
        'status' => 200,
        'error' => ''
      ]));
    die();
  }
  
}