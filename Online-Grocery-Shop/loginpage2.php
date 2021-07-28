<?php

include "configpage.php";
session_start();
global $connect;

if(isset($_POST["submit"])) {
    //echo isset($_POST["uname"]);
    if(empty(trim($_POST["uname"])) || empty(trim($_POST["pword"]))) {
        $_SESSION['empty'] = 'empty';
        $_SESSION['uname'] = $_POST["uname"];
        header("location:loginpage1.php");
    }
    else
    {
        $query="SELECT * FROM logindata WHERE  username='{$_POST['uname']}' AND password='{$_POST['pword']}'";
        //echo $query;
        $stmt=$connect->prepare($query);
        if(!$stmt->execute()) {
            var_dump($stmt->errorInfo());
            die("Dead while fetching");
        }

        if($stmt->rowCount() == 1)
        {
            $_SESSION["uname"] = $_POST["uname"];
            header("location:loginpage3.php");
        }
        else{
            $_SESSION["incorrect"] = $_POST["uname"];
            header("location:loginpage1.php");
        }
    }
}

?>
