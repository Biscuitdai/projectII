<?php
include '../connection.php';

// Retrieve the booking details from the query parameters
$user_id = isset($_GET['user_id']) ? $_GET['user_id'] : '';
$name = isset($_GET['name']) ? $_GET['name'] : '';
$movieName = isset($_GET['movieName']) ? $_GET['movieName'] : '';
$selectedDate = isset($_GET['selectedDate']) ? $_GET['selectedDate'] : '';


$totalBookedSeats = isset($_GET['totalBookedSeats']) ? $_GET['totalBookedSeats'] : '';
$totalAmount = isset($_GET['totalAmount']) ? $_GET['totalAmount'] : '';

// Set the filename for the downloaded bill
$filename = 'booking_bill_' . date('Y-m-d_H-i-s') . '.html';

// Assuming you have a bookings table with a column 'show_time'
$sql = "SELECT b.*, m.name AS movie_name, m.price AS seat_price, u.name AS user_name
        FROM booking b
        JOIN movie m ON b.movie_id = m.id
        JOIN user u ON b.user_id = u.id
        WHERE b.user_id = $user_id";

$result = $conn->query($sql);

if (!$result) {
    die("SQL Error: " . $conn->error);
}

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $selectedShowTime = $row['show_time']; // Update the show time from the database
       // Assuming you have a 'total_price' column

    // Generate the bill content with HTML and CSS
    $billContent = '<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Booking Bill</title>
        <style>
            


h1 {
    color: #333;
}

.bill {
    background-color: #f8f8f8;
    border: 1px solid #ddd;
    padding: 10px;
    margin-bottom: 20px;
}

.bill p {
    margin: 5px 0;
}

.total-amount {
    background-color: #dff0d8;
    border: 1px solid #d6e9c6;
    padding: 10px;
    margin-bottom: 20px;
}

.total-amount span {
    display: block;
    font-weight: bold;
    margin-bottom: 5px;
}

.thank-you {
    color: #31708f;
}
        </style>
    </head>
    <body>
        <h1>Booking Success</h1>
        <div class="bill">
            <p><strong>Name:</strong> ' . $name . '</p>
            <p><strong>Movie Name:</strong> ' . $movieName . '</p>
            <p><strong>Show Date:</strong> ' . $selectedDate . '</p>
            
            <p><strong>Total Seats:</strong> ' . $totalBookedSeats . '</p>
        </div>
        <div class="total-amount">
            <span>Total Amount Needs to Pay:</span>
            <span>Rs. ' . $totalAmount . '</span>
        </div>
        <div class="thank-you">
            <p>Thank You</p>
            <p>Thank you for booking with us. Enjoy the movie!</p>
        </div>
    </body>
    </html>';

    // Send appropriate headers for file download
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename="' . $filename . '"');

    // Output the bill content to the user for download
    echo $billContent;
    exit();
} else {
    // Handle case where no booking is found for the user
    echo "No booking found for the user.";
}

// Close the database connection
$conn->close();
?>
