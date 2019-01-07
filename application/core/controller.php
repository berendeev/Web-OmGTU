<?php 

abstract class Controller{
  protected static $session = [];
  abstract function index();
}