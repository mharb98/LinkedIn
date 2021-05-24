<?php
    require_once("userDataHandler.php");
    session_start();

    $user_id = $_SESSION["user_id"];

    $userDataHandler = new userDataHandler();

    $result = $userDataHandler->getUserType($user_id);

    echo $result;
?>