<?php
    require_once("userDataHandler.php");
    session_start();

    $staff_name = $_POST["staff"];
    $company_id = $_SESSION["user_id"];

    $userDataHandler = new userDataHandler();

    $result = $userDataHandler->deleteMember($company_id,$staff_name);

    echo $result;
?>