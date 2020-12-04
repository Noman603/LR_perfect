<?php 
    include'inc/header.php';
    include'lib/User.php';
    Session::checkSession();
    
?>
<?php
    $loginmsg = Session::get("loginmsg");
    if(isset($loginmsg)){
        echo $loginmsg;
    }
    Session::set("loginmsg",NULL);
?>
            
            <div class="panel panel-default">
                <h2>User List!<span style="float: right;">Welcome@<strong>
                    <?php
                    $name = Session::get("username") ;
                    if(isset($name)){
                        echo $name;
                    }
                    ?>  
                </strong></span></h2>
            </div>
            <table class="table table-hover">
            <thead>
                <tr>
                <th scope="col">#</th>
                <th scope="col">Name</th>
                <th scope="col">User Name</th>
                <th scope="col">Email</th>
                <th scope="col">Handle</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                    $user = new User();
                    $userData = $user->getUserData();
                    if($userData){
                        $i=0;
                        foreach ($userData as $sData) {
                            $i++;
                ?>
                <tr>
                <th><?php echo $i; ?></th>
                <td><?php echo $sData['name']; ?></td>
                <td><?php echo $sData['username']; ?></td>
                <td><?php echo $sData['email']; ?></td>
                <td> <a href="profile.php?id=<?php echo $sData['id']; ?>" class="btn btn-primary">Edit</a></td>
                </tr>
                <?php                      
                    }
                }?>
            </tbody>
            </table>

<?php include'inc/footer.php'; ?>