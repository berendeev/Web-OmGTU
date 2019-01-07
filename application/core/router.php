<?php 
class Router{
  private static $instance = null;
  private $routes = null;
  
  private function __construct(){
    $this->routes = [];
  }
  
 public static function getInstance(){
  if(is_null(self::$instance)){
    self::$instance = new Router();
  }
   return self::$instance;
  }
  
  public function route(string $route, string $handler, string $method = 'any'){
    if(empty($this->routes[$method]))
    {
      $this->routes[$method] = [];
    }
    
    $this->routes[$method][] = [
      'route'   => $route,
      'handler'  => $handler
    ];
  }
  
  public function process(){
    $request = preg_replace('~[?].*~', '', $_SERVER['REQUEST_URI']);
    $method = strtolower($_SERVER['REQUEST_METHOD']);

    $routes = array_merge(!empty($this->routes['any']) ? $this->routes['any'] : [], !empty($this->routes[$method]) ? $this->routes[$method] : []);

    foreach($routes as $route)
    {
      if(preg_match('~^/'.$route['route'].'$~Uui', $request))
      {
        $handler_parts = explode('/', $route['handler']);

        if(count($handler_parts) < 1)
        {
          echo 'Handler is empty!';
          require_once APP_PATH.'404.php';
          die();
        }

        if(!file_exists(APP_PATH.'application/controllers/'.$handler_parts[0].'_controller.php'))
        {
          echo 'Controller file not exists!';
          require_once APP_PATH.'404.php';
          die();
        }

        require_once(APP_PATH.'application/controllers/'.$handler_parts[0].'_controller.php');

        $class_name = ucfirst($handler_parts[0]).'Controller';
        if(!class_exists($class_name))
        {
          echo 'Controller class not exists!';
          require_once APP_PATH.'404.php';
          die();
        }
        $obj = new $class_name();
        $method = 'index';

        if(count($handler_parts) > 1)
        {
          if(!method_exists($obj, $handler_parts[1]))
          {
            echo 'Required method not exists!';
            require_once APP_PATH.'404.php';
            die();
          }
          $method = $handler_parts[1];
        }
        else
        {
          $obj->$method();
          return;
        }
        
        $args = [];
        $route_parts = explode('/', $route['route']);
        $request_parts = explode('/', preg_replace('~^\/~', '', $request));
        foreach($route_parts as $index => $part)
        {
          if(preg_match('~\[.*\]\+*~', $part, $match))
          {
            $args[] = $request_parts[$index];
            print_r($args);
          }
        }
        if(empty($args))
        {
          $obj->$method();
        }
        else
        {
          call_user_func_array([$class_name, $method], $args);
        }
        return;
      }
    }
    echo 'Page not exists!';
    require_once APP_PATH.'404.php';
  }
}
?>













