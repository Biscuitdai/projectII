<?php
require '../connection.php'; // Use consistent include/require
include 'header.php';
?>
<link rel="stylesheet" href="index.css">
<div class="movie-container">
<?php

// Check if a user is logged in
$isUserLoggedIn = isset($_SESSION['email']);

$sql = "SELECT * FROM movie";
$result = $conn->query($sql);

// Display movie cards
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $movie_id = $row['id'];
        $movie_name = $row['name'];
        $movie_image = $row['image'];
        $movie_price = $row['price'];

        echo "
        <div class='movie-card'>
            <img src='../images/$movie_image' alt='Movie Poster' class='movie-poster'>
            <div>
                <p class='movie-name'>$movie_name</p>
                <form action='booking.php' method='post'>
                    <input type='hidden' name='movie_id' value='$movie_id'>
                    <input type='submit' name='book_now' value='Book Now' class='book-button'>
                </form><br>
                <p>Per Ticket: Rs. $movie_price</p>
            </div>
        </div>
    ";
    
    }
} else {
    echo "No movies found.";
}
$conn->close();
?>
        </div>