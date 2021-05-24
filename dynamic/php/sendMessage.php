<?php
    require_once('messageDataHandler.php');
    require_once('userDataHandler.php');
    session_start();

    $user_id = $_SESSION["user_id"];
    $msg = $_POST["msg"];
    $contact_name = $_POST["contact"];

    $userDataHandler = new userDataHandler();

    $contact_id = $userDataHandler->getUserByName($contact_name);

    $messageDataHandler = new messageDataHandler();

    $result = $messageDataHandler->addMessage($msg,$user_id,$contact_id);

    echo $result;
?>