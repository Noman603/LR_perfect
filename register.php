<?php 
include'inc/header.php'; 
include'lib/User.php'; 
?>
<?php 
    $user = new User();
    if($_SERVER['REQUEST_METHOD'] == 'POST' & isset($_POST['register'])){
        $usrregi = $user->userRegistration($_POST);
    }
?>
            <section>
            <h3>User Register</h3>
                <div>
                    <?php

                     if(isset($usrregi)){
                        echo $usrregi;
                    }
                    ?>
                    <form action="" method="POST">
                        <div class="form-group">
                            <label> Name</label>
                            <input type="text" class="form-control" id="name" name="name">
                        </div>
                        <div class="form-group">
                            <label>User Name</label>
                            <input type="text" class="form-control" id="uname" name="uname">
                        </div>
                        <div class="form-group">
                            <label>Email address</label>
                            <input type="email" class="form-control" id="email" name="email">
                        </div>
                        
                        <div class="form-group">
                            <label>Password</label>
                            <input type="password" class="form-control" id="pass" name="password">
                        </div>
                        <button type="submit" class="btn btn-primary" id="register" name="register">Register</button>
                    </form>
                </div>
            </section>
            
<?php include'inc/footer.php'; ?>