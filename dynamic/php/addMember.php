<?php
    require_once('userDataHandler.php');
    session_start();

    $email = $_POST["email"];
    $company_id = $_SESSION["user_id"];
    
    $userDataHandler = new userDataHandler();

    $result = $userDataHandler->addMember($company_id,$email);

    echo $result;
?>