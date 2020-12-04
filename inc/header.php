<?php
    $filepath = realpath(dirname(__FILE__));
    include_once $filepath.'/../lib/Session.php';
    Session::init();
?>

<!DOCTYPE html>
<html>
    <head>
        <title>LGRG</title>
        <link rel="stylesheet" href="inc/bootstrap.min.css"/>
        <script src="inc/jquery.min.js"></script>
        <script src="inc/bootstrap.min.js"></script>   
        
    </head>
    <?php 

    if(isset($_GET['action']) && $_GET['action'] == "logout"){
        Session::destroy();
    }

    ?>

    <body>
        <div class="container">
            <section>
                <nav class="navbar navbar-expand-lg navbar-light bg-light">
                    <a class="navbar-brand" href="index.php"><h2><strong>Fiftytwo Digital Ltd</strong></h2></a>
                    
                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav">

                        <?php 
                        $id = Session::get("id");
                        $userlogin = Session::get("login");
                        if($userlogin == true){
                        ?>
                        <li class="nav-item">
                            <a class="nav-link" href="index.php">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="profile.php?id=<?php echo $id; ?>">Profile</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="?action=logout">Log Out</a>
                        </li>
                    <?php }else{?>
                        <li class="nav-item">
                            <a class="nav-link" href="register.php">Register</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="login.php">Log In</a>
                        </li>
                    <?php } ?>
                        </ul>
                    </div>
                </nav>
            </section>
            <div><br></div>
