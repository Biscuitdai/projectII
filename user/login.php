<?php
include("header.php");
require '../connection.php';

if(isset($_POST['signinBtn'])) {
    // Get the email and password from the form
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Retrieve the user's record based on their email
    $sql = "SELECT * FROM user WHERE email = '$email'";
    $result = $conn->query($sql);

    if (!$result) {
        echo "Error in query: " . $conn->error;
    } elseif ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $storedPassword = $row['password'];

        // Verify the provided plain-text password with the stored hashed password
        if (password_verify($password, $storedPassword)) {
            session_start(); // Start the session
            $_SESSION['user_id'] = $row['id']; // Store the user's ID in the session
            $_SESSION['email'] = $email;
            $_SESSION['user_name'] = $row['name'];
            header('Location: index.php'); // Redirect to the index page
            exit();
        } else {
            echo "Email or password invalid";
        }
    } else {
        echo "Email or password invalid";
    }
}
?>

<link rel="stylesheet" href="login.css">

<div class="login-container">
    <form class="login-form" method="post" action="login.php">
        <input class="login-input" type="text" placeholder="Enter Your Email" name="email" id="email" required><br>
        <input class="login-input" type="password" placeholder="Enter your password" name="password" id="password" required><br>
        <input class="login-submit" type="submit" name="signinBtn" value="Login">
    </form>
</div>