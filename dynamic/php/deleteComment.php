<?php
    require_once('commentDataHandler.php');
    session_start();

    $comment_id = $_POST["comment_id"];

    $commentDataHandler = new commentDataHandler();

    $result = $commentDataHandler->deleteComment($comment_id);

    echo $result;
?>