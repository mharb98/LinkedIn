<?php
    require_once('likersDataHandler.php');
    session_start();

    $company_id = $_SESSION["user_id"];

    $likersDataHandler = new likersDataHandler();

    $result = $likersDataHandler->getLikers($company_id);

    echo json_encode($result);
?>