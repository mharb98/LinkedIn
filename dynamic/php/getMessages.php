<?php
    require_once('messageDataHandler.php');
    session_start();

    $user_id = $_SESSION["user_id"];
    $contact_name = $_GET["contact_name"];

    $messageDataHandler = new messageDataHandler();

    $result = $messageDataHandler->getMessages($user_id,$contact_name);

    echo json_encode($result);
?>