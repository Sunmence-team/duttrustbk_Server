<?php
    require_once('config.php');
    require_once("app/model.php");

    class controller{
        protected $pdo;

        public function __construct(){
            $this->pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USERNAME, DB_PASSWORD);
        }


    }


