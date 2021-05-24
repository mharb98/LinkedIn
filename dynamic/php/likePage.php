<?php
    require_once('likersDataHandler.php');
    session_start();

    $company_id = $_POST["page_id"];
    $user_id = $_SESSION["user_id"];

    $likersDataHandler = new likersDataHandler();

    $result = $likersDataHandler->likePage($user_id,$company_id);

    echo $result;
?>