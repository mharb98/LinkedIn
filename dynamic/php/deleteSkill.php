<?php
    require_once('skillDataHandler.php');
    session_start();

    $user_id = $_SESSION["user_id"];

    $skill = $_POST["skill"];

    $skillDataHandler = new skillDataHandler();

    $result = $skillDataHandler->deleteSkill($user_id,$skill);

    echo $result;
?>