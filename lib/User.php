<?php
include_once 'Session.php';
include 'Database.php';

class User{
    private $db;
    public function __construct(){
        $this->db = new Database();
    }
    public function userRegistration($data){
    	$name     = $data['name'];
    	$username = $data['uname'];
    	$email    = $data['email'];
    	$password = $data['password'];
    	$chk_email = $this->emailCheak($email);

    	if($name == "" OR $username == "" OR $email == "" OR $password == ""){
    		$msg = "<div class='alert alert-danger' role='alert'><strong>Error!</strong>Field must not Empty.</div>";
    		return "$msg";
    	}
    	if(strlen($username) < 3){
    		$msg = "<div class='alert alert-danger' role='alert'>Username is too short.</div>";
    		return "$msg";
    	}
    	if(filter_var($email, FILTER_VALIDATE_EMAIL) === false){
    		$msg = "<div class='alert alert-danger' role='alert'><strong>Error!</strong>Email is not valid.</div>";
    		return "$msg";
    	}
    	if($chk_email == true){
    		$msg = "<div class='alert alert-danger' role='alert'><strong>Error!</strong>Email is existance.</div>";
    		return "$msg";
    	}
        $password     = md5($data['password']);
    	$sql = "INSERT into table_user(name, username, email, password) VALUES(:name, :username, :email, :password)";
    	$query = $this->db->pdo->prepare($sql);
    	$query->bindValue(':name', $name);
    	$query->bindValue(':username', $username);
    	$query->bindValue(':email', $email);
    	$query->bindValue(':password', $password);
    	$result = $query->execute();
    	if($result){
    		$msg = "<div class='alert alert-success' role='alert'><strong>Successful!</strong> You have been registered.</div>";
    		return "$msg";
    	}else{
    		$msg = "<div class='alert alert-danger' role='alert'><strong>Error!</strong></div>";
    		return "$msg";
    	}
    }
    public function emailCheak($email){
    	$sql = "SELECT email FROM table_user WHERE email = :email";
    	$query = $this->db->pdo->prepare($sql);
    	$query->bindValue(':email', $email);
    	$query->execute();
    	if($query->rowCount() > 0){
    		return true;
    	}else{
    		return false;     
    	}
    }

    public function getLoginUser($email ,$password){
    	$sql = "SELECT * FROM table_user WHERE email = :email AND password = :password LIMIT 1";
    	$query = $this->db->pdo->prepare($sql);
    	$query->bindValue(':email', $email);
    	$query->bindValue(':password', $password);
    	$query->execute();
    	$result = $query->fetch(PDO::FETCH_OBJ);
    	return $result;
    }
    public function userLogin($data){
    	$email    = $data['email'];
    	$password = md5($data['password']);

    	$chk_email = $this->emailCheak($email);

    	if($email == ""){
    		$msg = "<div class='alert alert-danger' role='alert'><strong>Error!</strong>Field must login Empty.</div>";
    		return "$msg";
    	}
    	if(filter_var($email, FILTER_VALIDATE_EMAIL) === false){
    		$msg = "<div class='alert alert-danger' role='alert'><strong>Error!</strong>Email is not login valid.</div>";
    		return "$msg";
    	}
    	$result = $this->getLoginUser($email ,$password);
    	if($result){
    		Session::init();
    		Session::set("login", true);
    		Session::set("id",$result->id);
    		Session::set("name",$result->name);
    		Session::set("username",$result->username);
    		Session::set("loginmsg","<div class='alert alert-success' role='alert'><strong>Successful!</strong> You have Logged In.</div>");
    		header('location:index.php');
    	}else{
            $msg = "<div class='alert alert-danger' role='alert'><strong>Error!</strong></div>";
            return "$msg";
        }
    }
    public function getUserData(){
        $sql = "SELECT * FROM table_user ORDER BY id DESC";
        $query = $this->db->pdo->prepare($sql);
        $query->execute();
        $result = $query->fetchAll();
        return $result;
    }
    public function getUserById($userid){
        $sql = "SELECT * FROM table_user WHERE id = :id LIMIT 1";
        $query = $this->db->pdo->prepare($sql);
        $query->bindValue(':id', $userid);
        $query->execute();
        $result = $query->fetch(PDO::FETCH_OBJ);
        return $result;
    }
    public function userUpdate($id ,$data){
        $name     = $data['name'];
        $username = $data['uname'];
        $email    = $data['email'];

        if($name == "" OR $username == "" OR $email == ""){
            $msg = "<div class='alert alert-danger' role='alert'><strong>Error!</strong>Field must not Empty.</div>";
            return "$msg";
        }
        if(strlen($username) < 3){
            $msg = "<div class='alert alert-danger' role='alert'>Username is too short.</div>";
            return "$msg";
        }
        if(filter_var($email, FILTER_VALIDATE_EMAIL) === false){
            $msg = "<div class='alert alert-danger' role='alert'><strong>Error!</strong>Email is not valid.</div>";
            return "$msg";
        }

        $sql = "UPDATE table_user set
                name = :name,
                username = :username,
                email = :email
                WHERE id = :id";

        $query = $this->db->pdo->prepare($sql);
        $query->bindValue(':name', $name);
        $query->bindValue(':username', $username);
        $query->bindValue(':email', $email);
        $query->bindValue(':id', $id);
        $result = $query->execute();
        if($result){
            $msg = "<div class='alert alert-success' role='alert'><strong>Successful!</strong> Data Updated Successfully.</div>";
            return "$msg";
        }else{
            $msg = "<div class='alert alert-danger' role='alert'><strong>Error!</strong></div>";
            return "$msg";
        }
    }
    public function chkPass($id, $old_pass){
        $password = md5($old_pass);
        $sql = "SELECT password FROM table_user WHERE id = :id AND password = :password";
        $query = $this->db->pdo->prepare($sql);
        $query->bindValue(':id', $id);
        $query->bindValue(':password', $password);
        $query->execute();
        if($query->rowCount() > 0){
            return true;
        }else{
            return false;     
        }
    }
    public function userUpdatePass($id,$data){
        $old_pass = $data['oldpass'];
        $new_pass = $data['newpass'];
        $chk_pass = $this->chkPass($id, $old_pass);

        if($old_pass == "" OR $new_pass == ""){
            $msg = "<div class='alert alert-danger' role='alert'><strong>Error!</strong>Field must not Empty.</div>";
            return "$msg";
        }
        if($chk_pass == false){
            $msg = "<div class='alert alert-danger' role='alert'><strong>Error!</strong>Old password not exist.</div>";
            return "$msg";
        }
        $password = md5($new_pass);
        $sql = "UPDATE table_user set
                password = :password
                WHERE id = :id";

        $query = $this->db->pdo->prepare($sql);
        $query->bindValue(':password', $password);
        $query->bindValue(':id', $id);
        $result = $query->execute();
        if($result){
            $msg = "<div class='alert alert-success' role='alert'><strong>Successful!</strong> Password Updated Successfully.</div>";
            return "$msg";
        }else{
            $msg = "<div class='alert alert-danger' role='alert'><strong>Error!</strong></div>";
            return "$msg";
        }
    }  
}

?>