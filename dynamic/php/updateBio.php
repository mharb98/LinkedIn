<?php
    require_once("userDataHandler.php");
    session_start();

    $id = $_SESSION["user_id"];
    
    $bio = $_POST["bio"];

    $userDataHandler = new userDataHandler();

    $result = $userDataHandler->updateBio($id,$bio);

    echo $result;
?>