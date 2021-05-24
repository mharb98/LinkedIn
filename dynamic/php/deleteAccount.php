<?php
    require_once("userDataHandler.php");
    session_start();

    $user_id = $_SESSION["user_id"];

    $userDataHandler = new userDataHandler();

    $result = $userDataHandler->deleteAccount($user_id);

    echo $result;
    //session_unset();

   // session_destroy();
?>