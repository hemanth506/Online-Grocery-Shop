<?php

include "configpage.php";
session_start();
$is_refreshed = (isset($_SERVER['HTTP_CACHE_CONTROL']) && $_SERVER['HTTP_CACHE_CONTROL'] == 'max-age=0')
?>

<html>
   <head>
       <h2 style="padding:60px;color: cadetblue">Welcome to Hekart</h2>
   </head>
    <body align="center">
        <form action="loginpage2.php" method="post" class="perfect-centering" >
            <?php
            if($is_refreshed) {
                if (isset($_SESSION['created'])) {
                    echo "<h5 style='color: green'>Account is created</h5>";
                    unset($_SESSION["created"]);
                }
                elseif(isset($_SESSION['acc_exist'])) {
                    echo "<h5 style='color: green'>Account already exist</h5>";
                    unset($_SESSION["acc_exist"]);
                }
                elseif(isset($_SESSION["incorrect"])) {
                    echo "<h5 style='color: green'>Check Email or Password</h5>";
                    unset($_SESSION["incorrect"]);
                }
            }
            ?>
            <div class="form-group col-md-12">
                <input type="email" id="inputEmail" class="form-control" name="uname" placeholder="Enter Email Address" value="<?php
                    if(isset($_SESSION['empty'])) {
                        echo $_SESSION['uname'];
                    }
                ?>">
            </div><br>
            <div class="form-group col-md-12">
                <input type="password" id="inputPassword" class="form-control" name="pword" placeholder="Enter Password">
            </div><br>
            <button class="btn btn-success" type="submit"  name="submit">Login</button><br>
            Do you have an account?<a href="signup.php">Sign up</a>
        </form>
    </body>
</html>