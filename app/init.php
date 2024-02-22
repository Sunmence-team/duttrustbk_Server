<?php

require_once("router.php");

Router::post("/register", "postController", "register");




header("HTTP/1.0 404 Not Found");
$response = array(
    'status' => 'failed',
    'message' => 'this route is not found on this server'
);

echo json_encode($response);
exit();