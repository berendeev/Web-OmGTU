<?php 
define('APP_PATH', '/home/cabox/workspace/');
$core = glob(APP_PATH.'application/core/*');
foreach($core as $path){
  require_once($path);
}

require_once(APP_PATH.'application/routes.php');
$router = Router::getInstance();
$router->process();
?>