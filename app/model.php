<?php

class model
{
    protected $pdo;
    protected $user_table;

    public function __construct($pdo){
        $this->pdo = $pdo;
    }

    public function register($data){
        
        if(empty($data['email']) || empty($data['fullname']) || empty($data['password']) || empty($data["username"])){
            header("HTTP/1.0 400 Bad Request");
            $response = array(
                'status' => 'failed',
                'message' => 'all feilds are required.'
            );
            return $response;
        }
        try {
            $email = $data['email'];
            $fullname = $data['fullname'];
            $username = $data['username'];
            $password = $data['password'];
            
           

            $stn = $this->pdo->prepare('SELECT * FROM `user` WHERE `email` = :email');
            $stn->bindParam(':email', $email, PDO::PARAM_STR);
            $stn->execute();
            $row = $stn->fetch(PDO::FETCH_ASSOC);
            
            if($row){
                header("HTTP/1.0 409 Conflict");
                $response = array(
                    'status' => 'failed',
                    'message' => 'email already have been registered and updated.'
                );
                return $response;
            }

            $stn = $this->pdo->prepare('INSERT INTO `user`(`fullname`, `email`, `username`, `password`) VALUES (:fullname, :email, :username, :password)');
           
           
            $stn->bindParam(':fullname', $fullname, PDO::PARAM_STR);
            $stn->bindParam(':email', $email, PDO::PARAM_STR);
            $stn->bindParam(':username', $username, PDO::PARAM_STR);
            $stn->bindParam(':password', $password, PDO::PARAM_STR);
            
            $stn->execute();

            if($stn){
                $response = array(
                    'status' => 'success',
                    'message' => 'succesfully creared an acccount with us.',
                    'email' => $email,
                    'fulname' => $fullname,
                    'username' => $username
                );
                return $response;
            }else{
                header("HTTP/1.0 500 Internal Server Error");
                $response = array(
                    'status' => 'failed',
                    'message' => 'failed to upload details to the database.'
                );
                return $response;
            }
        } catch (PDOException $e) {
            error_log("Database Error: " . $e->getMessage());
    
            $errorMessage = "A database error occurred. Please contact the administrator.";
    
            // return $e->getMessage();
            return $this->generateErrorResponse($errorMessage);
        }
        
    }

}