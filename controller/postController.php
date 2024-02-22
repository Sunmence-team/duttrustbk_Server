<?php

    require_once('app/controller.php');
    require_once("app/model.php");
    
    class postController extends controller
    {
        
        public function register($file, $data){
            $register = new Model($this->pdo);
            $register = $register->register($data);

        
            if($register){
                session_start();
                $_SESSION["user_data"] = $register;
                echo json_encode($_SESSION["user_data"]);
            }else{
                echo json_encode($register);
            }
        }
    }