<?php

include "configpage.php";
session_start();
global $connect;

if(isset($_POST["signup"])) {
    //echo isset($_POST["uname"]);
    $_SESSION['email'] = $_POST['email'];
    if(empty(trim($_POST["email"])) || empty(trim($_POST["pword"])) || empty(trim($_POST["cpword"]))) {
        header("location:signup.php");
    }
    else
    {
        $query="SELECT * FROM logindata WHERE  username='{$_POST['email']}' AND password='{$_POST['pword']}'";
//        echo $query;
//        die();
        $stmt = $connect->prepare($query);
        if(!$stmt->execute()) {
            var_dump($stmt->errorInfo());
            die("Dead while fetching");
        }

        if($stmt->rowCount() > 1) {
            $_SESSION['acc_exist'] = 1;
            header("location:loginpage1.php");
        }
        else{
//            echo "mot exist";die();
            if($_POST['pword'] == $_POST['cpword']) {
                $insertQuery = "Insert into logindata (username,password,confirm_pass) Values (:uname, :pword, :cpword)";
                $stmt = $connect->prepare($insertQuery);
                $stmt->bindParam(':uname', $_POST['email']);
                $stmt->bindParam(':pword', $_POST['pword']);
                $stmt->bindParam(':cpword', $_POST['cpword']);
                if (!$stmt->execute()) {
                    var_dump($stmt->errorInfo());
                    die("Dead while inserting");
                }
                $_SESSION['created'] = 'done';
                header("location:loginpage1.php");
            }
            elseif($_POST['pword'] != $_POST['cpword']){
                header("location:signup.php");
            }
        }
    }
}