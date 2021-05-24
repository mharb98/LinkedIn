<?php
    require_once('userDataHandler.php');
    session_start();

    $user_id = $_SESSION["user_id"];

    $userDataHandler = new userDataHandler();

    $result = $userDataHandler->getPicture($user_id);

    $json->key = $result;

    echo json_encode($json);
?>