<?php
require_once "config.php";
class Controller{
    private $db;
    function __construct($con){
        $this->db=$con;
    }

}