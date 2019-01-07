<?php
class BookDao extends Dao{
  
  public function __construct(){
     parent::__construct();
  }
  
  public function addBook($title, $body, $picture){
    $sql = 'INSERT INTO book (title, body, picture) VALUES (?, ?, ?)';
    $this->db->query($sql, [$title, $body, $picture]);
  }
  
  public function getAllBooks(){
    $sql = 'SELECT * FROM book';
    return $this->db->query($sql, []);
  }
  
  public function getBookById($bookid){
    $sql = 'SELECT * FROM book WHERE id = ?';
    return $this->db->query($sql, [$bookid]);
  }
  
  public function updateBook($bookid, $title, $body, $picture){
    $sql = 'UPDATE book SET title = ?, body = ?, picture = ? WHERE id = ?';
    return $this->db->query($sql, [$title, $body, $picture, $bookid]);
  }
  
  public function deleteBook($bookid){
    $sql = 'DELETE FROM book WHERE id = ?';
    return $this->db->query($sql, [$bookid]);
  }
  
  
  
}