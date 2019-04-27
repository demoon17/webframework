<?php
    session_start();

    //connect to db
    $db = mysqli_connect("localhost", "root" , "","registration");

    if (isset($_POST['login'])){
        $email = $_POST['email'];
        $password = $_POST['password'];
        
        $password = md5($password); //hash password before storing for security 
        $sql = "SELECT * FROM userdetail WHERE email='$email' AND password='$password'";
        $result = mysqli_query($db, $sql);

        if (mysqli_num_rows($result)==1){
            $_SESSION['message'] = "You are now logged in";
            $_SESSION['email'] = $email;
            header("location: index.php"); //redirect to home page
        }
        else{
            $_SESSION['message'] = "Username/Password incorrect! Try again";

        }
    
    }

?>