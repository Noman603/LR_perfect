<?php 
include'lib/user.php'; 
include'inc/header.php'; 
Session::checkSession();
?>
<?php
    if(isset($_GET['id'])){
        $userid = (int)$_GET['id'];
        $sessionId = Session::get("id");
        if($sessionId != $userid){
            header('location:index.php');
        }
    }
    $user = new user();
    if($_SERVER['REQUEST_METHOD'] == 'POST' & isset($_POST['updatepass'])){
        $usrUpdatePass = $user->userUpdatePass($userid, $_POST);
    }
?>
            <section>
            <h2>Change Password<span style="float: right;"></h2>
                <div>
                    <?php 
                        if(isset($usrUpdatePass)){
                            echo $usrUpdatePass;
                        }
                    ?>
                    <form action="" method="POST">
                        <div class="form-group">
                            <label> Old Password</label>
                            <input type="Password" class="form-control" name="oldpass">
                        </div>
                        <div class="form-group">
                            <label>New Password</label>
                            <input type="Password" class="form-control" name="newpass">
                        </div>
                        <button type="submit" class="btn btn-primary" id="update" name="updatepass">Update</button>
                    </form>
                </div>
            </section>
            
<?php include'inc/footer.php'; ?>