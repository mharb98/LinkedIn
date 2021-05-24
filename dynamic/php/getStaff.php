<?php
    require('userDataHandler.php');
    session_start();

    $company_id = $_SESSION["user_id"];

    $userDataHandler = new userDataHandler();

    $result = $userDataHandler->getStaff($company_id);

    echo json_encode($result);
?>