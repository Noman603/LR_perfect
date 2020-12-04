<?php 
include'lib/user.php'; 
include'inc/header.php'; 
Session::checkSession();
?>
<?php
    if(isset($_GET['id'])) {
        $userid = $_GET['id'];
    }
    $user = new user();
    if($_SERVER['REQUEST_METHOD'] == 'POST' & isset($_POST['update'])){
        $usrUpdate = $user->userUpdate($userid, $_POST);
    }
?>
            <section>
            <h2>User Profile<span style="float: right;"><a class="btn btn-primary" href="index.php">Back</a></span></h2>
                <div>
                    <?php 
                        if(isset($usrUpdate)){
                            echo $usrUpdate;
                        }
                    ?>
                    <?php
                        $userdata = $user->getUserById($userid);
                        if($userdata){
                    ?>
                    <form action="" method="POST">
                        <div class="form-group">
                            <label> Name</label>
                            <input type="text" class="form-control" id="name" name="name" value="<?php echo $userdata->name;?>">
                        </div>
                        <div class="form-group">
                            <label>User Name</label>
                            <input type="text" class="form-control" id="uname" name="uname" value="<?php echo $userdata->username;?>" >
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Email address</label>
                            <input type="email" class="form-control" id="email" name="email" value="<?php echo $userdata->email;?>">
                        </div>
                        <?php 
                            $sessionId = Session::get("id");
                            if($sessionId == $userid){    
                        ?>
                        <button type="submit" class="btn btn-primary" id="update" name="update">Update</button>
                        <a class="btn btn-info" id="updatepass" name="updatepass" href="changepass.php?id=<?php echo $id; ?>">Change Password</a>
                    <?php } ?>
                    </form>

                <?php } ?>
                </div>
            </section>
            
<?php include'inc/footer.php'; ?>