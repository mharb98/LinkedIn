<?php
    require_once("userDataHandler.php");
    session_start();
    $id = $_SESSION["user_id"];
    $name = $_POST["name"];

    $userDataHandler = new userDataHandler();

    $result = $userDataHandler->updateUserName($id,$name);

    echo $result;
?>