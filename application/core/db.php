<?php
class DataBase
{
  private static $instance = null;
  
  public static function getInstance()
  {
    if(is_null(self::$instance))
    {
      self::$instance = new DataBase();
    }
    return self::$instance;
  }
  
  private $connection = null;
  
  private $error = null;

  private $row_count = 0;

  public function __construct()
  {
    $this->connection = new PDO(
      'mysql:dbname='.'bookdb'.';host='.'localhost'.';', 
      'root', 
      '');
  }
  
  public function query(string $request, array $params = [])
  {
    $lastId = $this->getLastId();
    $count = 0;
    $statment = $this->connection->prepare($request);
    $result = $statment->execute($params);
    $this->error = $statment->errorInfo();
    if($result)
    {
      try
      {
        if($statment->columnCount() > 0)
        {
          $this->row_count = 0;
          return $statment->fetchAll(PDO::FETCH_ASSOC);
        }
        $this->row_count = $statment->rowCount();
        return $result;
      }
      catch(Exception $e)
      {
        $this->row_count = 0;
        return $result;
      }
    }
    return $result;
  }
  
  public function getError()
  {
    return $this->error;
  }
  
  public function getLastId()
  {
    $statment = $this->connection->prepare('SELECT LAST_INSERT_ID() as last_insert_id');
    if($statment->execute([]))
    {
      $result = $statment->fetchAll(PDO::FETCH_ASSOC);
      if(!empty($result))
      {
        return $result[0]['last_insert_id'];
      }
    }
    return -1;
  }

  public function getRowCount()
  {
      return $this->row_count;
  }
}