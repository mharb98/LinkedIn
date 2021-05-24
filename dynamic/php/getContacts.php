<?php
    require_once('userDataHandler.php');
    session_start();

    $user_id = $_SESSION["user_id"];

    $userDataHandler = new userDataHandler();

    $result = $userDataHandler->getContacts($user_id);

    echo json_encode($result);
?>