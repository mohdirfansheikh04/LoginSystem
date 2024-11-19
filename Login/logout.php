<?php
// Start the session
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_logged_in'])) {
    // Redirect to the login page if not logged in
    header("Location: login.php");
    exit();
}

// Simulate user logout (you would typically do this by destroying the session)
if (isset($_GET['action']) && $_GET['action'] == 'logout') {
    // Destroy the session or perform logout logic here
    session_destroy();
    $logoutMessage = "You have been logged out. Thank you for using our service. We hope to see you again soon!";
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
    <div class="container text-center" style="margin-top: 100px;">
        <?php if (isset($logoutMessage)): ?>
            <h1><?php echo $logoutMessage; ?></h1>
            <a href="login.php" class="btn btn-primary">Return to Login</a>
        <?php else: ?>
            <h1>Are you sure you want to logout?</h1>
            <a href="?action=logout" class="btn btn-danger">Logout</a>
            <a href="welcome.php" class="btn btn-secondary">Cancel</a>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>