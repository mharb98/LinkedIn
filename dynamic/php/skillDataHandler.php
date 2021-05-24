<?php
    require_once("DBConn.php");
    class skillDataHandler{
        public function insertSkill($id,$skill){
            $obj = DBConn::getConn();
            $conn = $obj->connect();

            $getter = "SELECT * FROM skill WHERE user_id='$id'";

            $result = mysqli_query($conn,$getter);

            $num_rows = mysqli_num_rows($result);

            for($i=0;$i<$num_rows;$i++){
                $row = mysqli_fetch_assoc($result);
                if($row["skill_name"]===$skill){
                    return "Skill already exists";
                }
            }

            $query = "INSERT into skill (skill_id,skill_name,user_id) VALUES (null,'$skill','$id')";

            $status = $conn->query($query);

            $obj->disconnect();

            if($status==TRUE){
                return "New skill added scuccessfully";
            }
            else{
                return "Failed to add new skill, try again later";
            }
        }

        public function getSkills($id){
            $obj = DBConn::getConn();
            $conn = $obj->connect();

            $getter = "SELECT * FROM skill WHERE user_id='$id'";

            $result = mysqli_query($conn,$getter);

            $num_rows = mysqli_num_rows($result);

            $obj->disconnect();

            $arr = array();

            for($i=0;$i<$num_rows;$i++){
                $row = mysqli_fetch_assoc($result);
                $arr[$i] = $row["skill_name"];
            }

            return $arr;
        }

        public function deleteSkill($id,$skill){
            $obj = DBConn::getConn();
            $conn = $obj->connect();

            $query = "DELETE FROM skill WHERE user_id='$id' AND skill_name='$skill'";

            if($conn->query($query)==TRUE){
                return TRUE;
            }

            return FALSE;
        }

        public function deleteAllSkills($user_id){
            $obj = DBConn::getConn();
            $conn = $obj->connect();

            $query = "SELECT skill_id FROM skill WHERE user_id='$user_id'";

            $result = mysqli_query($conn,$query);

            $num_rows = mysqli_num_rows($result);

            if($num_rows > 0){
                $query = "DELETE FROM skill WHERE user_id='$user_id'";
                $status = $conn->query($query);
            }

            $obj->disconnect();
        }
    }
?>