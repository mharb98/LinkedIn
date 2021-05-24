<?php
    require_once('DBConn.php');
    require_once('skillDataHandler.php');
    require_once('postDataHandler.php');
    require_once('messageDataHandler.php');
    require_once('likersDataHandler.php');
    require_once('commentDataHandler.php');
    class userDataHandler{

        public function insertUser($name,$email,$pass,$cpass,$birthday,$type){
                $obj = DBConn::getConn();
                $conn = $obj->connect();
                $resp = "New user added successfully";

                if($pass!=$cpass){
                    $resp = "Confirmed password doesn't match password";
                    return $resp;
                }

                if($type=="user"){
                    $type = 0;
                }
                else{
                    $type = 1;
                }

                $query = "INSERT into user (user_id,user_name,user_email,password,type,birthday,bio,profile_pic)
                    Values (NULL,'$name','$email','$pass','$type','$birthday','No bio yet',NULL)";

                if($conn->query($query)===TRUE){
                    echo $resp;
                }
                else{
                    $resp = "Error".$conn->connect->error;
                    return $resp;
                }
               $obj->disconnect();
        }

        public function checkUser($email,$pass){
            $obj = DBConn::getConn();
            $conn = $obj->connect();

            $query = "SELECT * from user WHERE user_email = '$email'";

            $result = mysqli_query($conn,$query);

            $obj->disconnect();

            $number_of_rows = mysqli_num_rows($result);

            if($number_of_rows==1){
                $first_row = mysqli_fetch_assoc($result);
                $password = $first_row["password"];
                if($pass==$password){
                    return $first_row["user_id"];
                }
                else{
                    return "Wrong password";
                }
            }
            else{
                return "No such user!";
            }
        }

        public function updateUserName($id,$name){
            $obj = DBConn::getConn();
            $conn = $obj->connect();

            $query = "UPDATE user SET user_name='$name' WHERE user_id='$id'";

            if($conn->query($query)==TRUE){
                $obj->disconnect();
                return "User name updated successfully";
            }
            else{
                $obj->disconnect();
                return "Failed to update user name";
            }
        }

        public function updatePassword($id,$pass,$cpass){
            $obj = DBConn::getConn();
            $conn = $obj->connect();

            if($pass != $cpass){
                return "Confirmed password doesn't match password";
            }
            else{
                $query = "UPDATE user SET password='$pass' WHERE user_id='$id'";
                if($conn->query($query)==TRUE){
                    $obj->disconnect();
                    return "Password update successfully";
                }
                else{
                    $obj->disconnect();
                    return "Failed to update password, try again later";
                }
            }
        }

        public function updateEmail($id,$email){
            $obj = DBConn::getConn();
            $conn = $obj->connect();

            $query = "UPDATE user SET user_email='$email' WHERE user_id='$id'";

            if($conn->query($query)==TRUE){
                $obj->disconnect();
                return "Email updated successfully";
            }
            else{
                $obj->disconnect();
                return "Failed to update email, try again later";
            }
        }

        public function updateBirthday($id,$birthday){
            $obj = DBConn::getConn();
            $conn = $obj->connect();

            $query = "UPDATE user SET birthday='$birthday' WHERE user_id='$id'";

            if($conn->query($query) == TRUE){
                $obj->disconnect();
                return "Birthday updated successfully";
            }
            else{
                $obj->disconnect();
                return "Failed to update birthday, tyy again later";
            }
        }

        public function updateBio($id,$bio){
            $obj = DBConn::getConn();
            $conn = $obj->connect();

            $query = "UPDATE user SET bio='$bio' WHERE user_id='$id'";

            $status = $conn->query($query);

            $obj->disconnect();

            if($status==TRUE){
                echo "Bio updated successfully";
            }
            else{
                echo "Failed to update bio, please try again later";
            }
        }

        public function updateProfilePicture($id,$picture){
            $obj = DBConn::getConn();
            $conn = $obj->connect();
            $dummy = $conn->real_escape_string($picture);

            $query = "UPDATE user SET profile_pic='$dummy' WHERE user_id='$id'";

            $status = $conn->query($query);

            $obj->disconnect();
           
            if($status==TRUE){
                return "Profile picture updated successfully";
            }
            else{
                return "Couldn't update profile picture";
            }
        }

        public function getUserType($id){
            $obj = DBConn::getConn();
            $conn = $obj->connect();

            $query = "SELECT * FROM user WHERE user_id='$id'";

            $result = mysqli_query($conn,$query);

            $obj->disconnect();

            $number_of_rows = mysqli_num_rows($result);

            if($number_of_rows>0){
                $row = mysqli_fetch_assoc($result);
                $type = $row["type"];
                return $type;
            }
            
            return 2;
        }

        public function getUserInfo($user_id){
            $obj = DBConn::getConn();
            $conn = $obj->connect();

            $query = "SELECT * FROM user WHERE user_id='$user_id'";

            $result = mysqli_query($conn,$query);

            $obj->disconnect();

            $number_of_rows = mysqli_num_rows($result);

            if($number_of_rows==1){
                $row = mysqli_fetch_assoc($result);
                $row["profile_pic"] = base64_encode($row["profile_pic"]);
                return $row;
            }

            return null;
        }

        public function getUserByName($contact_name){
            $obj = DBConn::getConn();
            $conn = $obj->connect();

            $query = "SELECT user_id FROM user WHERE user_name='$contact_name'";

            $result = mysqli_query($conn,$query);

            $row = mysqli_fetch_assoc($result);

            $contact_id = $row["user_id"];

            return $contact_id;
        }

        public function addMember($company_id,$email){
            $obj = DBConn::getConn();
            $conn = $obj->connect();

            $query = "SELECT * FROM user WHERE user_email = '$email'";

            $result = mysqli_query($conn,$query);

            $row = mysqli_fetch_assoc($result);

            $type = $row["type"];
            $user_id = $row["user_id"];

            $flag = FALSE;

            if($type==0){
                $flag = TRUE;
            }
            else{
                return "Please enter an employee's email, you enter a company's email";
            }
            $query = "SELECT * FROM staff_member WHERE company_id='$company_id' AND user_id='$user_id'";

            $result = mysqli_query($conn,$query);

            $num_of_rows = mysqli_num_rows($result);

            if($num_of_rows>0){
                return "Member already exists in your staff";
            }

            if($flag==TRUE){
                $query = "INSERT INTO staff_member (staff_id,company_id,user_id) VALUES (null,'$company_id','$user_id')";
                if($conn->query($query)){
                    $obj->disconnect();
                    return "New member added to company";
                }
            }
            return "Failed to enter new member";
        }

        public function getStaff($company_id){
            $obj = DBConn::getConn();
            $conn = $obj->connect();

            $getter = "SELECT * FROM staff_member WHERE company_id='$company_id'";

            $result = mysqli_query($conn,$getter);

            $num_rows = mysqli_num_rows($result);

            $arr = array();

            for($i=0;$i<$num_rows;$i++){
                $row = mysqli_fetch_assoc($result);
                $user_id = $row["user_id"];
                
                $query = "SELECT * FROM user WHERE user_id='$user_id'";

                $result2 = mysqli_query($conn,$query);

                $num_employees = mysqli_num_rows($result2);

                for($j=0;$j<$num_employees;$j++){
                    $row2 = mysqli_fetch_assoc($result2);

                    $user_name = $row2["user_name"];

                    $arr[$j] = $user_name;
                }
            }

            $obj->disconnect();

            return $arr;
        }

        public function deleteMember($company_id,$member_name){
            $obj = DBConn::getConn();
            $conn = $obj->connect();

            $query = "SELECT * FROM user WHERE user_name='$member_name'";

            $result = mysqli_query($conn,$query);

            $row = mysqli_fetch_assoc($result);

            $user_id = $row["user_id"];

            $query = "DELETE FROM staff_member WHERE company_id='$company_id' AND $user_id='$user_id'";

            $status = $conn->query($query);

            $obj->disconnect();

            if($status == TRUE){
                return "Staff member deleted successfully";
            }
            else{
                return "Failed to delete staff member, try again later";
            }
        }

        public function deleteAccount($user_id){
            $obj = DBConn::getConn();
            $conn = $obj->connect();

            $query = "SELECT staff_id FROM staff_member WHERE company_id='$user_id' OR user_id='$user_id'";

            $result = mysqli_query($conn,$query);

            $num_rows = mysqli_num_rows($result);

            $status = null;

            if($num_rows > 0){
                $query = "DELETE FROM staff_member WHERE user_id='$user_id' OR company_id='$user_id'";
                $status = $conn->query($query);
            }

            $skillDataHandler = new skillDataHandler();
            $skillDataHandler->deleteAllSkills($user_id);

            $postDataHandler = new postDataHandler();
            $postDataHandler->deleteAllPosts($user_id);

            
            $messageDataHandler = new messageDataHandler();
            $messageDataHandler->checkMessages($user_id);

            $likersDataHandler = new likersDataHandler();
            $likersDataHandler->checkLikers($user_id);

            $commentDataHandler = new commentDataHandler();
            $commentDataHandler->checkComments($user_id);

            $query = "DELETE FROM user WHERE user_id='$user_id'";

            $status = $conn->query($query);

            if($status==FALSE){
                return "Could not delete account, please try again later";
            }

            return "Account deleted thanks";
        }

        public function getContacts($user_id){
            $obj = DBConn::getConn();
            $conn = $obj->connect();

            $query = "SELECT user_name FROM user WHERE user_id<>'$user_id'";

            $result = mysqli_query($conn,$query);

            $num_rows = mysqli_num_rows($result);

            $arr = array();

            for($i=0;$i<$num_rows;$i++){
                $row = mysqli_fetch_assoc($result);
                $arr[$i] = $row["user_name"];
            }

            $obj->disconnect();

            return $arr;
        }
    }
?>