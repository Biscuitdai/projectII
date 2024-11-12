<?php
require '../connection.php';
include 'header.php';
date_default_timezone_set('Asia/Kathmandu');

?>
<?php
$movieId = $_POST['movie_id'];
$selectedDate = $_POST['selected_date'];
$selectedShowTime = $_POST['selected_show_time'];
$selectedShowTimeFormatted = date('H:i:s', strtotime($selectedShowTime));

// Retrieve booked seat IDs from the database
$sqlBookedSeats = "SELECT seat_num FROM booking WHERE movie_id = $movieId AND show_date = '$selectedDate' AND show_time = '$selectedShowTimeFormatted'  AND canceled='0'";
$resultBookedSeats = $conn->query($sqlBookedSeats);
$bookedSeatIds = [];
if ($resultBookedSeats && $resultBookedSeats->num_rows > 0) {
    while ($row = $resultBookedSeats->fetch_assoc()) {
        $bookedSeatIds[] = $row['seat_num'];
    }
}

// Check if the user is logged in and the email address is available in the session
if (!isset($_SESSION['email'])) {
    // Redirect the user to the login page or display an error message
    header('Location: login.php');
    exit;
}

// Get the email address of the logged-in user
$email = $_SESSION['email'];

if (isset($_POST['bookSeats'])) {
    // Fetch the ticket price for the selected movie from the database
    $sqlMoviePrice = "SELECT price FROM movie WHERE id = $movieId";
    $resultMoviePrice = $conn->query($sqlMoviePrice);
    if ($resultMoviePrice && $resultMoviePrice->num_rows > 0) {
        $row = $resultMoviePrice->fetch_assoc();
        $ticketPrice = floatval($row['price']);
    } else {
        echo "<p>Error fetching ticket price.</p>";
        // You may handle this error as per your requirement
        exit;
    }

    // Ensure $_POST data is present and correct
    if (isset($_POST['seats']) && is_array($_POST['seats'])) {
        $selectedSeats = $_POST['seats'];
        $availableSeats = array_diff($selectedSeats, $bookedSeatIds);

        // Check if any seats are available to book
        if (count($availableSeats) > 0) {
            $totalPrice = count($availableSeats) * $ticketPrice; // Calculate the total price

            // Start a transaction to ensure consistency in the database
            $conn->begin_transaction();

            try {
                foreach ($availableSeats as $seatId) {
                    // Insert the booking details along with the user's name, email, and show_time
                    $sqlInsertBooking = "INSERT INTO booking (movie_id, show_date, show_time, booking_date, booking_time, seat_num, total_price, user_id) 
                    VALUES ($movieId, '$selectedDate', '$selectedShowTime', now(), now(), $seatId, $totalPrice, {$_SESSION['user_id']})";

                    if ($conn->query($sqlInsertBooking) !== TRUE) {
                        throw new Exception("Error booking Seat $seatId: " . $conn->error);
                    }
                }

                // Commit the transaction if all insertions are successful
                $conn->commit();

                echo "<p>Seats booked successfully!</p>";

                // Get the current date and time
                $bookingDate = date('Y-m-d');
                $bookingTime = date('H:i:s');

                // Redirect to uploadimages.php with date and time as URL parameters
                header("Location: uploadimages.php?booking_date=$bookingDate&booking_time=$bookingTime");
                exit;

            } catch (Exception $e) {
                // Rollback the transaction in case of any error during insertions
                $conn->rollback();
                echo "<p>Booking failed: " . $e->getMessage() . "</p>";
            }
        } else {
            echo "<p>All selected seats are already booked.</p>";
        }
    } else {
        echo "";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Seat Booking Form</title>
    <link rel="stylesheet" href="seats.css">
</head>
<body>
    <div class="container">
        <h1>Seat Booking Form</h1>
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
            <p>Ticket Price: Rs.<span id="ticketPrice"><?php echo $ticketPrice; ?></span></p>
            <p>Total Price: Rs.<span id="totalPrice">0.00</span></p>
            <input type="hidden" name="movie_id" value="<?php echo $movieId; ?>">
            <input type="hidden" name="selected_date" value="<?php echo $selectedDate; ?>">
            <input type="hidden" name="selected_show_time" value="<?php echo $selectedShowTime; ?>">
            <input type="hidden" name="booking_date" value="<?php echo date('Y-m-d'); ?>">
            <input type="hidden" name="booking_time" value="<?php echo date('H:i:s'); ?>">
            <label>
                <?php echo '<p>Hi ' . $_SESSION['user_name'] . ', Choose your seats.</p>'; ?>
            </label>

            <label>Select Seats:</label>
            <div class="seat-row">
                <?php
                $seatId = 1;
                for ($i = 1; $i <= 35; $i++) {
                    $isBooked = in_array($seatId, $bookedSeatIds);
                    $disabled = $isBooked ? "disabled" : "";
                    $selectedClass = $isBooked ? "selected" : "";
                    echo "
                        <div class='seat $selectedClass'>
                            <input type='checkbox' name='seats[]' value='$seatId' $disabled>
                            Seat $seatId
                        </div>
                    ";
                    $seatId++;
                }
                ?>
            </div>
            <input type="submit" name="bookSeats" value="Book Seats">
            
            <a href="index.php">Cancel Booking</a>
            
        </form>
    </div>
    <script>
        const ticketPrice = parseFloat(document.getElementById('ticketPrice').textContent);

        document.querySelectorAll('input[name="seats[]"]').forEach(seat => {
            seat.addEventListener('change', updateTotalPrice);
        });

        function updateTotalPrice() {
            const selectedSeats = Array.from(document.querySelectorAll('input[name="seats[]"]:checked')).map(seat => parseInt(seat.value));
            const totalPrice = selectedSeats.reduce((total, seat) => total + ticketPrice, 0);
            document.getElementById('totalPrice').textContent = totalPrice.toFixed(2);
        }
    </script>
</body>
</html>
