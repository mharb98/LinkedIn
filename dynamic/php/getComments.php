<?php
    require_once('commentDataHandler.php');

    $post_id = $_GET["post_id"];

    $commentDataHandler = new commentDataHandler();

    $result = $commentDataHandler->getComments($post_id);

    echo json_encode($result);
?>