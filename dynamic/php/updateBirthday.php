<?php
    require_once('userDataHandler.php');
    session_start();

    $id = $_SESSION["user_id"];
    $birthday = $_POST["birthday"];

    $userDataHandler = new userDataHandler();

    $result = $userDataHandler->updateBirthday($id,$birthday);

    echo $result;
?>