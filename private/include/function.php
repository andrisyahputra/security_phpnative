<?php
class Database
{
    private function connection()
    {

        try {
            //code...
            $string = "mysql:host=localhost;dbname=security_db";
            $con = new PDO($string, "root", "");
        } catch (PDOException $th) {
            if ($_SERVER['HTTP_HOST'] == "localhost") {
                die($th->getMessage());
            } else {
                die("could not connect to the database");
            }
        }

        return $con;
    }
    public function db_read($query, $data = array())
    {
        $con = $this->connection();
        $stm = $con->prepare($query);
        if ($stm) {
            $check = $stm->execute($data);
            if ($check) {
                $result = $stm->fetchAll(PDO::FETCH_ASSOC);
                if (is_array($result) && count($result) > 0) {
                    return $result;
                }
            }
        }

        return false;
    }

    public function db_write($query, $data = array())
    {
        $con = $this->connection();
        $stm = $con->prepare($query);
        if ($stm) {
            $check = $stm->execute($data);
            if ($check) {

                return true;

            }
        }

        return false;
    }
}
class Posts extends Database
{

    public function get_home_posts()
    {
        $query = "select * from posts order by id desc limit 2";
        return $this->db_read($query);
    }
    public function get_all_posts()
    {
        $query = "select * from posts order by id desc";
        return $this->db_read($query);
    }

    public function get_one_posts($id)
    {
        $arr = array();
        // $id = (int)$id;
        // $id = addslashes($id);
        $arr['id'] = (int) $id;
        $query = "select * from posts where id = :id limit 1";
        return $this->db_read($query, $arr);
    }

}

class User extends Database
{
    public function register($POST)
    {

        //validate
        //email
        if (!filter_var($POST['email'], FILTER_VALIDATE_EMAIL)) {
            $Error = "Please add a valid email";
        }

        //name
        if (empty($POST['name'])) {
            $Error = "Please select a valid name";
        }

        //password
        if (empty($POST['password'])) {
            $Error = "Please select a valid password";
        }

        //gender
        if (empty($POST['gender'])) {
            $Error = "Please select a valid gender";
        }

        if ($Error == "") {
            $arr = [];
            $arr['email'] = addslashes($POST['email']);
            $arr['password'] = addslashes($POST['password']);
            $arr['gender'] = addslashes($POST['gender']);
            $arr['name'] = addslashes($POST['name']);
            $arr['rank'] = "user";

            //save user
            $query = "insert into users (email,password,gender,name,rank) values (:email,:password,:gender,:name,:rank)";
            // $result = mysqli_query($con, $query);
            return $this->db_read($query, $arr);

        }
        return $Error;
    }
    public function login($POST)
    {
        $Error = "";

        //validate
        //email
        if (!filter_var($POST['email'], FILTER_VALIDATE_EMAIL)) {
            $Error = "wrong email or password";
        }

        //password
        if (empty($POST['password'])) {
            $Error = "wrong email or password";
        }

        if ($Error == "") {
            $arr = [];
            $arr['email'] = addslashes($POST['email']);
            $arr['password'] = addslashes($POST['password']);

            //get user
            $query = "select * from users where email = :email && password = :password ";
            // echo "$query";
            // die;
            $result = $this->db_read($query, $arr);

            if ($result) {
                $row = $result[0];

                $_SESSION['user_id'] = $row['id'];
                $_SESSION['user_rank'] = $row['rank'];

                return "";
            } else {
                $Error = "wrong email or password";
            }

        }
        return $Error;
    }

    public function get_profile($id)
    {
        $arr = [];
        $arr['id'] = (int) $id;
        $query = "select * from users where id = :id limit 1";
        return $this->db_read($query, $arr);
    }
}

function access($needed_rank)
{
    $user_rank = isset($_SESSION['user_rank']) ? $_SESSION['user_rank'] : "";
    switch ($needed_rank) {
        case 'admin':
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

function clean($data)
{

    return htmlspecialchars($data);

}
