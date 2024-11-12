
<?php
include 'header.php';
require_once "../connection.php";

// Initialize error variables
$emailErr = $passwordErr = $cpasswordErr = $phoneErr = "";

// Check if the registration form is submitted
if (isset($_POST['signupBtn'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $cpassword = $_POST['cpassword'];
    $phone_no = $_POST['phone_no'];

    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $emailErr = "Invalid email format";
    }

    // Check if the email already exists in the database
    $existing_email_query = "SELECT email FROM admin WHERE email = '$email'";
    $result = $conn->query($existing_email_query);
    if ($result->num_rows > 0) {
        $emailErr = "Email already exists.";
    }

    // Validate password length
    if (strlen($password) < 6 || strlen($password) > 16) {
        $passwordErr = "Password must be between 6 and 16 characters long.";
        
    }

    // Check if password and confirm password match
    if ($password !== $cpassword) {
        $cpasswordErr = "Passwords do not match.";
    }

    // If there are no errors, proceed with the registration process
    if (empty($emailErr) && empty($passwordErr) && empty($cpasswordErr)) {
        $hashedNewPassword = password_hash($password, PASSWORD_DEFAULT);
        // Insert user data into the database
        $sql = "INSERT INTO admin (name, email, password, phone_no) VALUES ('$name', '$email', '$hashedNewPassword', '$phone_no')";
        if ($conn->query($sql) === true) {
            header('location: login.php');
            exit();
        } else {
            echo "Error: " . $conn->error;
        }
    }
}


?>

<link rel="stylesheet" href="register.css">
<div class="register">
    <div>
        <h1 id="Title">Sign Up</h1>
        <h2>LET'S ENJOY MOVIE WORLD</h2>
        <form action="register.php" method="POST">
        <div>
    <div>
        <input type="text" placeholder="Enter Your Name" id="name" name="name" required value="<?php echo isset($_POST['name']) ? $_POST['fname'] : ''; ?>"><br>
    </div>
    <div>
        <input type="email" placeholder="Enter Your Email" id="email" name="email" required value="<?php echo isset($_POST['email']) ? $_POST['email'] : ''; ?>"><br>
    </div>
    <div><?php echo $emailErr; ?></div>

    <!-- Display error message for password -->
    <div>
        <input type="password" placeholder="Enter Your Password" id="password" name="password" required><br>
    </div>
    <div><?php echo $passwordErr; ?></div>

    <!-- Display error message for confirm password -->
    <div>
        <input type="password" placeholder="Confirm Password" id="cpassword" name="cpassword" required><br>
    </div>
    <div><?php echo $cpasswordErr; ?></div>

    <!-- Display error message for phone -->
    <div>
        <input type="contact" placeholder="Enter Your Phone Number" id="phone" name="phone_no" required ><br>
    </div>
    <div><?php echo $phoneErr; ?></div>

    <div class="SignUp-link">
        <button type="submit" name="signupBtn">Sign Up</button>
        <br>
    </div>
    <p>Already have an account? <a href="login.php">Sign in</a></p>
</div>

        </form>
    </div>
</div>
