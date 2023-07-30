<?php
class Database {
    private function connection(){
        if(!$con = mysqli_connect("localhost","root","","security_db"))
			{
				die("could not connect to the database");
			}
        return $con;
    }
    public function db_read($query){
        $con = $this->connection();
        $result = mysqli_query($con,$query);

        if($result && mysqli_num_rows($result) > 0)
        {
                $data = [];
                while ($row = mysqli_fetch_assoc($result)) {
                    // code...

                    //display posts
                    $data[]= $row;
            }

            
            return $data;
        }
        
        return false;
    }

    public function db_write($query){
        $con = $this->connection();
        $result = mysqli_query($con,$query);

        if($result)
        {          
            return true;
        }
        
        return false;
    }
}
class Posts extends Database {

    public function get_home_posts(){
        $query = "select * from posts order by id desc limit 2";
			return $this->db_read($query);
    }
    public function get_all_posts(){
        $query = "select * from posts order by id desc";
			return $this->db_read($query);
    }
    
    public function get_one_posts($id){
        $query = "select * from posts where id= '$id' limit 1";
			return $this->db_read($query);
    }
    
}

class User extends Database {
    function login($POST)
    {
        $Error = "";

        //validate
        //email
        if(!filter_var($POST['email'],FILTER_VALIDATE_EMAIL))
        {
            $Error = "wrong email or password";
        }

        //password
        if(empty($POST['password']))
        {
            $Error = "wrong email or password";
        }

        
        if($Error == "")
        {
            $email	= addslashes($POST['email']);
            $password	= addslashes($POST['password']);
    
            //get user
            $query = "select * from users where email = '$email' && password = '$password' ";
            $result = $this->db_read($query);
    
            if($result)
            {
                $row = $result[0];
                    
                $_SESSION['user_id'] = $row['id'];
                $_SESSION['user_rank'] = $row['rank'];

                return "";
            }else {
                $Error = "wrong email or password";
            }

        }
        return $Error;
    }
}

function access($needed_rank)
{
    $user_rank =isset( $_SESSION['user_rank']) ?  $_SESSION['user_rank'] : "";
    switch ($needed_rank) {
        case 'value':
            # code...
            $allowed[] = "admin";

            return in_array($user_rank, $allowed);
            break;
        
        case 'editor':
            # code...
            $allowed[] = "admin";
            $allowed[] = "editor";

            return in_array($user_rank, $allowed);
            break;
        
        case 'user':
            # code...
            
            $allowed[] = "admin";
            $allowed[] = "editor";
            $allowed[] = "user";

            return in_array($user_rank, $allowed);
            break;
        
        default:
            # code...
            break;
    }
    return false;
}