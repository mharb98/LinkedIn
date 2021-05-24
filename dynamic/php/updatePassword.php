<?php
    require_once("userDataHandler.php");
    session_start();

    $id = $_SESSION["user_id"];
    $password = $_POST["password"];
    $confirm_password = $_POST["confirm_password"];

    $userDataHandler = new userDataHandler();

    $result = $userDataHandler->updatePassword($id,$password,$confirm_password);

    echo $result;
?>