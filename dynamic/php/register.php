<?php
    require_once('userDataHandler.php');

    session_start();

    $name = $_POST["uname"];
    $email = $_POST["email"];
    $pass = $_POST["pass"];
    $cpass = $_POST["cpass"];
    $birthday = $_POST["birthday"];
    $type = $_POST["type"];

    $userDataHandler = new UserDataHandler();

    if($_FILES['file2']){
        $pic = file_get_contents($_FILES['file2']['tmp_name']);
        $temp_id = $_SESSION["temp"];

        $resp = $userDataHandler->updateProfilePicture($temp_id,$pic);

        unset($_SESSION["temp"]);
        unset($_FILES['file2']);

        echo "New user added successfully";
    }
    else{
        $arr["name"] = $name;
        $arr["email"] = $email;
        $arr["pass"] = $pass;
        $arr["cpass"] = $cpass;
        $arr["birthday"] = $birthday;
        $arr["type"] = $type;

        $resp = $userDataHandler->insertUser($name,$email,$pass,$cpass,$birthday,$type);

        $_SESSION["temp"] = $userDataHandler->checkUser($email,$pass);
    }
?>