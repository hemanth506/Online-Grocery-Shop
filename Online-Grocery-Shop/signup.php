<?php

include "configpage.php";
session_start();
?>
<html>
   <head>
<!--       <h2>User Sign Page</h2>-->
   </head>
    <body align="center">
        <form action="signup2.php" method="post" class="perfect-centering">
            <div class="form-group col-md-12">
            <input type="email" name="email" class="form-control" placeholder="Enter Email">
            </div><br>
            <div class="form-group col-md-12">
            <input type="password" name="pword" class="form-control" placeholder="Enter Password">
            </div><br>
            <div class="form-group col-md-12">
            <input type="password" name="cpword" class="form-control" placeholder="Enter Confirm Password">
            </div><br>
            <input class="btn btn-success" type="submit" value="Sign up" name="signup">
            <br>
            Already have an account?<a href="loginpage1.php">Go to login</a><br>
        </form>
    </body>
</html>