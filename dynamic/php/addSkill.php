<?php
    require_once("skillDataHandler.php");
    session_start();

    $id = $_SESSION["user_id"];
    $skill = $_POST["skill"];

    $skillDataHandler = new skillDataHandler();

    $result = $skillDataHandler->insertSkill($id,$skill);
    
    echo $result;
?>