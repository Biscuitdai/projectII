<?php
include 'header.php';

if (isset($_GET['details'])) {
    $cancellationDetails = json_decode(urldecode($_GET['details']), true);

    if ($cancellationDetails) {
        echo "<div class='booking-details'>";
        echo "<h2>Booking Canceled</h2>";
        echo "<p>Your booking has been canceled. Details:</p>";
        echo "<ul>";
        echo "<li><strong>User Name:</strong> {$cancellationDetails['user_name']}</li>";
        echo "<li><strong>Movie Name:</strong> {$cancellationDetails['movie_name']}</li>";
        echo "<li><strong>Show Date:</strong> {$cancellationDetails['show_date']}</li>";
        echo "<li><strong>Show Time:</strong> {$cancellationDetails['show_time']}</li>";
        // Add other details as needed
        echo "</ul>";
        echo "</div>";
    } else {
        echo "Failed to retrieve booking details.";
    }
} else {
    echo "No details provided.";
}


?>
