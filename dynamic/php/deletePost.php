<?php
    require_once('postDataHandler.php');
    session_start();

    $post_id = $_POST["post_id"];

    $postDataHandler = new postDataHandler();

    $result = $postDataHandler->deletePost($post_id);

    echo $result;
?>