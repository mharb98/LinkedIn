<?php
    require_once('userDataHandler.php');

    session_start();

    $email = $_POST["email"];
    $pass = $_POST["pass"];

    $userDataHandler = new userDataHandler();

    $result = $userDataHandler->checkUser($email,$pass);

    $_SESSION["user_id"] = $result;
?>