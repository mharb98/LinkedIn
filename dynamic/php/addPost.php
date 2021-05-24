<?php
    require_once('postDataHandler.php');
    session_start();

    $user_id = $_SESSION["user_id"];
    $text = $_POST["text"];

    if($_FILES["file"]){
        $pic = file_get_contents($_FILES["file"]["tmp_name"]);
        
        $postDataHandler = new postDataHandler();

        $result = $postDataHandler->addPost($user_id,$text,$pic);

        echo $result;
    }else{
        echo "Please upload a valid picture";
    }
?>