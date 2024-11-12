<?php
require '../connection.php';
include 'header.php';
?>

<link rel="stylesheet" href="booking.css">
<?php
if (isset($_POST['book_now'])) {
    if (empty($_POST['movie_id'])) {
        echo "Movie ID not provided.";
        exit;
    }
    $movie_id = $_POST['movie_id'];
}

// Check if the user is logged in
$isUserLoggedIn = isset($_SESSION['email']);

if (isset($_POST['movie_id'])) {
    $movie_id = $_POST['movie_id'];
    $sql = "SELECT * FROM movie WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $movie_id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $name = $row['name'];
        $genre = $row['genre'];
        $industry = $row['industry'];
        $language = $row['language'];
        $duration = $row['movie_duration'];
        $reldate = $row['release_date'];
        $director = $row['movie_director'];
        $actor = $row['actor'];
        $image = $row['image'];
        $first_date = $row['first_date'];
        $second_date = $row['second_date'];
        $third_date = $row['third_date'];
        $first_show = $row['first_show'];
        $second_show = $row['second_show'];
        $third_show = $row['third_show'];
        $first_date = date('Y-m-d', strtotime($first_date));
        $second_date = date('Y-m-d', strtotime($second_date));
        $third_date = date('Y-m-d', strtotime($third_date));
        $first_show = date('H:i:s', strtotime($first_show));
        $second_show = date('H:i:s', strtotime($second_show));
        $third_show = date('H:i:s', strtotime($third_show));

        echo "
            <div class='booking-container'>
                <img src='../images/$image' alt='Movie Poster' class='booking-image'>
                <div class='movie-details'>
                    <h1>$name</h1>
                    <p><span>Genre:</span> $genre</p>
                    <p><span>Industry:</span> $industry</p>
                    <p><span>Language:</span> $language</p>
                    <p><span>Duration:</span> $duration</p>
                    <p><span>Release Date:</span> $reldate</p>
                    <p><span>Director:</span> $director</p>
                    <p><span>Actor:</span> $actor</p>
                </div>
            </div>";
    } else {
        echo "Movie not found.";
    }
}
?>

<div class='booking-form'>
    <h2>Select Date and Time</h2>
    <form action='seats.php' method='post'>
        <label for='selected_date'>Select Date:</label><br>
        <select name='selected_date' class='booking-date'>
            <?php
            if (!empty($first_date) && $first_date >= '1970-01-01') {
                echo "<option value='$first_date'>$first_date</option>";
            }
            if (!empty($second_date) && $second_date >= '1970-01-01') {
                echo "<option value='$second_date'>$second_date</option>";
            }
            if (!empty($third_date) && $third_date >= '1970-01-01') {
                echo "<option value='$third_date'>$third_date</option>";
            }
            ?>
        </select>

        Show:
        <select name='selected_show_time' class='booking-show'>
            <?php
            if (!empty($first_show) && $first_show != '00:00:00') {
                echo "<option value='$first_show'>$first_show</option>";
            }
            if (!empty($second_show) && $second_show != '00:00:00') {
                echo "<option value='$second_show'>$second_show</option>";
            }
            if (!empty($third_show) && $third_show != '00:00:00') {
                echo "<option value='$third_show'>$third_show</option>";
            }
            ?>
        </select>

        <input type='hidden' name='selected_show_date' value=''>
        <input type='hidden' name='first_show' value=''>
        <input type='hidden' name='movie_id' value='<?php echo $movie_id; ?>'>
        <br>

        <?php
        if ($isUserLoggedIn) {
            echo "<input type='submit' name='bookSeats' value='Book Seats' class='booking-button'>";
        } else {
            echo "<p>Please log in to book.</p>";
        }
        ?>
    </form>
</div>
