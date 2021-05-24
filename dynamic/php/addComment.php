<?php
    require_once('commentDataHandler.php');
    session_start();

    $user_id = $_SESSION["user_id"];
    $post_id = $_POST["post_id"];
    $text = $_POST["text"];

    $commentDataHandler = new commentDataHandler();

    $result = $commentDataHandler->addComment($user_id,$post_id,$text);

    echo $result;
?>