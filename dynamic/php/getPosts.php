<?php
    require_once("postDataHandler.php");
    session_start();

    $user_id = $_SESSION["user_id"];
    $belongs = $_GET["belongs"];

    $postDataHandler = new postDataHandler();

    $result = $postDataHandler->getPosts($user_id,$belongs);

    echo json_encode($result);
?>