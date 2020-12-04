<?php 
include'inc/header.php'; 
include'lib/User.php'; 
Session::checkLogin();
?>
<?php 
    $user = new User();
    if($_SERVER['REQUEST_METHOD'] == 'POST' & isset($_POST['submit'])){
        $usrLogin = $user->userLogin($_POST);
    }
?>
            <section>
            <h3>User Log In</h3>
                <div>
                    <?php

                     if(isset($usrLogin)){
                        echo $usrLogin;
                    }
                    ?>
                    <form action="" method="POST">
                        <div class="form-group">
                            <label>Email address</label>
                            <input type="email" class="form-control" id="email" name="email">
                        </div>
                        
                        <div class="form-group">
                            <label>Password</label>
                            <input type="password" class="form-control" id="password" name="password">
                        </div>
                        <button type="submit" class="btn btn-primary" id="submit" name="submit">Submit</button>
                    </form>
                </div>
            </section>
            
<?php include'inc/footer.php'; ?>