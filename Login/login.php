<?php
    $login = false;
    $err = false;
    session_start();
    
    

    if($_SERVER['REQUEST_METHOD']=='POST'){
    // connect to the database
            include 'partials/_dbconnect.php';

            

            // get form data
            $email = $_POST['email'];
            $password = $_POST['password'];
            // $confirmPassword = $_POST['confirm_password'];

            // check if the username already exists
            $exists = false;
            $emailex = false;
            

            
                // $sql = "SELECT * FROM userinfo WHERE email = '$email' AND password = '$password';";
                $sql = "SELECT * FROM userinfo WHERE email = '$email';";
                $result = mysqli_query($conn, $sql);
                
                $num = mysqli_num_rows($result);

                if($num == 1){
                    while($row = mysqli_fetch_assoc($result)){
                        if(password_verify($password, $row['password'])){
                            $login = true;
                            session_start();
                            $_SESSION['loggedin'] = true;
                            $_SESSION['email'] = $email;
                            $_SESSION['user_logged_in'] = true;
                            header("Location: welcome.php");
                        }
                        else{
                            $err = true;
                        }
                    }
                    
                }
                else{
                    $err = true;
                }
    }
    //check if uase is already login
    if (isset($_SESSION['user_logged_in'])) {
        // Redirect to the login page if not logged in
        header("Location: welcome.php");
        exit();
    }
?>





<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
    <title>Login</title>
    <?php require 'partials/_nav.php' ?>

    <!-- Login info -->

    <?php
   if($login==true){
        echo ' <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>Success! </strong>You have been logged in.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
        } 
        if($err==true){
            echo ' <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Error! </strong>Your password has been not matched.
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>';
            }   
   ?>


   
    <div class="container mt-5">
        <h2 class="text-center">Login</h2>
        <form action="login.php" method="POST" class="mt-4">
            <div class="mb-3">
                <label for="email" class="form-label">Email address</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <button type="submit" class="btn btn-primary">Login</button>
        </form>
        <div class="mt-3">
            <p>Don't have an account? <a href="signup.php">Register here</a></p>
        </div>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>