<?php
    require_once('DBConn.php');

    class messageDataHandler{

        public function checkMessages($user_id){
            $obj = DBConn::getConn();
            $conn = $obj->connect();

            $query = "SELECT message_id FROM message WHERE sender='$user_id' OR receiver='$user_id'";

            $result = mysqli_query($conn,$query);

            $num_rows = mysqli_num_rows($result);

            if($num_rows > 0){
                $query = "DELETE FROM message WHERE sender='$user_id' OR receiver='$user_id'";
                $status = $conn->query($query);
            }

            $obj->disconnect();
        }

        public function addMessage($text,$user_id,$contact_id){
            $obj = DBConn::getConn();
            $conn = $obj->connect();

            $query = "INSERT INTO message (message_id,text,sender,receiver)
                      VALUES (null,'$text','$user_id','$contact_id')";

            $status = $conn->query($query);

            if($status==TRUE){
                return "Message sent successfully";
            }

            return "Failed to send message, try again later";
        }

        public function getMessages($user_id,$contact_name){
            $obj = DBConn::getConn();
            $conn = $obj->connect();

            $query = "SELECT user_id FROM user WHERE user_name='$contact_name'";

            $result = mysqli_query($conn,$query);

            $row = mysqli_fetch_assoc($result);

            $contact_id = $row["user_id"];

            $query = "SELECT * FROM message where (sender = '$user_id' AND receiver = '$contact_id')
                    OR (receiver = '$user_id' AND sender = '$contact_id')";

            $result = mysqli_query($conn,$query);            

            $num_rows = mysqli_num_rows($result);

            $arr = array();
            $ids = array();

            for($i=0;$i<$num_rows;$i++){
                $row = mysqli_fetch_assoc($result);
                $arr[$i] = $row;
                $ids[$i] = $row["message_id"];
            }

            $obj->disconnect();

            sort($ids);

            $ret = array();

            for($i=0;$i<sizeof($ids);$i++){
                $id = $ids[$i];
                for($j=0;$j<sizeof($arr);$j++){
                    if($arr[$j]["message_id"]==$id){
                        $ret[$i] = $arr[$j];
                        if($ret[$i]["sender"]==$user_id){
                            $ret[$i]["sender"] = "You";
                            $ret[$i]["receiver"] = "Other";
                        }
                        else{
                            $ret[$i]["sender"] = "Other";
                            $ret[$i]["receiver"] = "You";
                        }
                    }
                }
            }

            return $ret;
        }
    }
?>