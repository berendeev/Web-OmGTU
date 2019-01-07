<?php 
$router = Router::getInstance();

$router->route('', 'base');
$router->route('login', 'login/api_login', 'post');
$router->route('logout', 'login/api_logout', 'post');
$router->route('registration', 'login/api_registration', 'post');

$router->route('books', 'book/addBook_api', 'post');
$router->route('books', 'book/getBooks_api', 'get');
$router->route('books', 'book/updateBook_api', 'put');
$router->route('books', 'book/deleteBook_api', 'delete');
?>