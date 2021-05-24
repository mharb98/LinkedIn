<?php
    require_once("DBConn.php");

    class likersDataHandler{

        public function likePage($user_id,$company_id){
            $obj = DBConn::getConn();
            $conn = $obj->connect();

            $query = "SELECT liker_id FROM company_liker WHERE user_id='$user_id' AND company_id='$company_id'";

            $result = mysqli_query($conn,$query);

            $num_rows = mysqli_num_rows($result);

            if($num_rows>0){
                $obj->disconnect();
                return "You already liked the page";
            }

            $query = "INSERT INTO company_liker (liker_id,user_id,company_id)
                      VALUES (null,$user_id,$company_id)";

            $status = $conn->query($query);

            if($status==TRUE){
                return "Like added successfully";
            }
            
            return "Failed to like page, please try again later";
        }

        public function getLikers($company_id){
            $obj = DBConn::getConn();
            $conn = $obj->connect();

            $query = "SELECT user_id FROM company_liker WHERE company_id='$company_id'";

            $result = mysqli_query($conn,$query);

            $num_rows = mysqli_num_rows($result);
            
            $arr = array();

            for($i=0;$i<$num_rows;$i++){
                $row = mysqli_fetch_assoc($result);

                $user_id = $row["user_id"];

                $query = "SELECT user_name FROM user WHERE user_id='$user_id'";

                $result2 = mysqli_query($conn,$query);

                $row2 = mysqli_fetch_assoc($result2);

                $user_name = $row2["user_name"];

                $arr[$i] = $user_name;
            }

            $obj->disconnect();

            return $arr;
        }

        public function checkLikers($user_id){
            $obj = DBConn::getConn();
            $conn = $obj->connect();

            $query = "SELECT liker_id FROM company_liker WHERE user_id='$user_id' OR company_id='$user_id'";

            $result = mysqli_query($conn,$query);

            $num_rows = mysqli_num_rows($result);

            if($num_rows > 0){
                $query = "DELETE FROM company_liker WHERE user_id='$user_id' OR company_id='$user_id'";
                $status = $conn->query($query);
            }

            $obj->disconnect();

            return $num_rows;
        }
    }
?>