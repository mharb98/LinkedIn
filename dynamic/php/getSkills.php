<?php
    require_once("skillDataHandler.php");
    session_start();
    $user_id = $_SESSION["user_id"];
    
    $skillDataHandler = new skillDataHandler();

    $result = $skillDataHandler->getSkills($user_id);

    echo json_encode($result);
?>