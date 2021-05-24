<?php
    require_once('userDataHandler.php');
    session_start();

    $id = $_SESSION["user_id"];
    $email = $_POST["email"];
    
    $userDataHandler = new userDataHandler();

    $result = $userDataHandler->updateEmail($id,$email);

    echo $result;

?>