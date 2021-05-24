<?php
    require_once("userDataHandler.php");
    session_start();

    if($_FILES['file']){
        $pic = file_get_contents($_FILES['file']['tmp_name']);

    $id = $_SESSION["user_id"];

        
    $userDataHandler = new userDataHandler();

    $result = $userDataHandler->updateProfilePicture($id,$pic);

    echo $result;
    }
    else{
        echo "Please upload a valid file";
    }
?>