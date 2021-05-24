<?php
    require_once("postDataHandler.php");
    session_start();

    $user_id = $_SESSION["user_id"];

    $post_id = $_POST["post_id"];

    $postDataHandler = new postDataHandler();

    $result = $postDataHandler->likePost($user_id,$post_id);

    echo $result;
?>