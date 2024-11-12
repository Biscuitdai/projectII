<?php
session_start();
date_default_timezone_set('Asia/Kathmandu');

require '../connection.php';
include 'header.php';

// Check if the user is logged in and the email address is available in the session
if (!isset($_SESSION['email'])) {
    // Redirect the user to the login page or display an error message
    header('Location: login.php');
    exit;
}

// Get the user ID of the logged-in user
$userId = $_SESSION['user_id'];
if (isset($_GET['booking_date']) && isset($_GET['booking_time'])) {
    $booking_date = $_GET['booking_date'];
    $booking_time = $_GET['booking_time'];

    // Fetch the total_price from the booking table
    $sqlTotalPrice = "SELECT total_price FROM booking WHERE user_id = $userId AND booking_date = '$booking_date' AND booking_time = '$booking_time' LIMIT 1";
    $resultTotalPrice = $conn->query($sqlTotalPrice);

    if ($resultTotalPrice && $resultTotalPrice->num_rows > 0) {
        $rowTotalPrice = $resultTotalPrice->fetch_assoc();
        $totalPrice = $rowTotalPrice['total_price'];

        // Display total price
        echo "<div style='text-align: center; max-width: 600px; margin: 50px auto; background-color: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);'>";
        echo "<p style='color: #333;'>Your seats have been Reserved, To confirm your seats<br>You need to pay: Rs. " . number_format($totalPrice, 2) . " on ESEWA or KHALTI and upload the screenshot of your payment<br>ESEWA id: 9860922423<br>KHALTI ID: 9860922423<br></p>";
        echo "<p style='color: #555;'>*Note: If you pay less amount than shown on the screen, then automatically your booked seats will be decreased.</p>";
        echo "</div>";
    } else {
        echo "Error fetching total price: " . $conn->error;
    }
}

// Check if form is submitted
if (isset($_POST['submit'])) {
    // Check if there are uploaded files
    if (isset($_FILES['images']) && is_array($_FILES['images']['tmp_name']) && count($_FILES['images']['tmp_name']) > 0) {
        // Define upload directory
        $uploadDir = '../uploads/';

        // Start a transaction to ensure consistency in the database
        $conn->begin_transaction();

        try {
            // Iterate through each uploaded file
            foreach ($_FILES['images']['tmp_name'] as $key => $tmpName) {
                // Check for file upload errors
                if ($_FILES['images']['error'][$key] !== UPLOAD_ERR_OK) {
                    echo "File upload error: " . $_FILES['images']['error'][$key];
                    // Handle the error appropriately
                    continue; // Skip this file and move to the next one
                }

                // Generate a unique filename
                $fileName = uniqid() . '_' . $_FILES['images']['name'][$key];

                // Define the full path for the file
                $targetPath = $uploadDir . $fileName;

                // Move the uploaded file to the destination
                if (move_uploaded_file($tmpName, $targetPath)) {
                    // Update the 'image_path' column in the 'booking' table
                    $imagePath = $fileName;
                    $bookingDate = $_POST['booking_date'];
                    $bookingTime = $_POST['booking_time'];

                    $sql = "UPDATE booking SET image_path = ? WHERE user_id = ? AND booking_date = ? AND booking_time = ?";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param('siss', $imagePath, $userId, $bookingDate, $bookingTime);
                    $stmt->execute();

                    if ($stmt->affected_rows > 0) {
                        // File uploaded and database updated successfully
                        $conn->commit();
                        header('Location: booking-success.php');
                        exit;
                    } else {
                        echo "Error updating database. No rows affected.";
                    }

                    $stmt->close();
                } else {
                    echo "";
                }
            }
        } catch (Exception $e) {
            // Rollback the transaction in case of any error during insertions
            $conn->rollback();
            echo "Error: " . $e->getMessage();
        }
    } else {
        echo "";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Upload Images</title>
    <link rel="stylesheet" href="seats.css">
</head>
<body>
    <div class="container">
        <h1 class="upload-h1">Upload Images</h1>
        <form class="upload-form" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">
            <!-- Assuming you have a hidden input field for booking_date and booking_time -->
            <input type="hidden" name="booking_date" value="<?php echo $_GET['booking_date']; ?>">
            <input type="hidden" name="booking_time" value="<?php echo $_GET['booking_time']; ?>">

            <label class="upload-label">Select Images:</label>
            <input class="upload-input" type="file" name="images[]" multiple accept="image/*">

            <input class="upload-button" type="submit" name="submit" value="Upload Images">
        </form>

        <a class="back-to-booking" href="index.php">Back to Booking</a>
    </div>
</body>
</html>
