<?php
$showAlert = false;
$err = false;
$exists = false;


session_start();

// Check if the user is logged in
if (isset($_SESSION['user_logged_in'])) {
    // Redirect to the login page if not logged in
    header("Location: welcome.php");
    exit();
}

if($_SERVER['REQUEST_METHOD']=='POST'){
    // connect to the database
    include 'partials/_dbconnect.php';

    

    // get form data
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirm_password'];

    // check if the username already exists

    $existSql = "SELECT * FROM userinfo WHERE email = '$email';";
    $result = mysqli_query($conn, $existSql);
    $numExistRows = mysqli_num_rows($result);
    if($numExistRows>0){
        $exists = true;
    }
    else{
        $exists = false;
        if(($password === $confirmPassword) && $exists==false){
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $sql = "INSERT INTO `userinfo` (`user_name`, `email`, `password`, `date`) VALUES ('$username', '$email', '$hash', current_timestamp());";
            $result = mysqli_query($conn, $sql);
            if($result){
                // header('location: login.php');
                $showAlert = true;
            }
        }
        else{
            $err = true;
        }
    }
    
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
    <title>Sign Up</title>
    <?php require 'partials/_nav.php' ?>

    <!-- alert -->
   <?php
   if($showAlert==true){
        echo ' <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>Success! </strong>You have been signup, now you can login easily. 
                    <a href="login.php">Login Now</a>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
        } 
        if($err==true){
            echo ' <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Error! </strong>Your password has been not matched.
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>';
            }
            if($exists==true){
                echo ' <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>Error! </strong>The user is already exist.
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>';
                }   
   ?>
   
    <!-- Creating a signup page in html-->
    <div class="container mt-5">
        <h2>Sign Up</h2>
        <form action="signup.php" method="POST">
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" id="username" name="username" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email Address</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <div class="mb-3">
                <label for="confirm_password" class="form-label">Confirm Password</label>
                <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
            </div>
            <button type="submit" class="btn btn-primary">Sign Up</button>
        </form>
    </div>
        

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>