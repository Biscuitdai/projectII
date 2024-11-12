<link rel="stylesheet" href="mybooking.css">

<?php
include '../connection.php';
include 'header.php';

$user_id = $_SESSION['user_id'];
$cancellationStatus = '';

// Function to cancel a booking by ID and update the 'canceled' column
function cancelBooking($conn, $bookingId) {
    // Get the booking date and time for the booking being canceled
    $sql_get_booking = "SELECT show_date, show_time FROM booking WHERE id = $bookingId";
    $result = $conn->query($sql_get_booking);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $bookingDate = $row['show_date'];
        $bookingTime = $row['show_time'];

        // Update the 'canceled' column for all bookings with the same date and time
        $updateSql = "UPDATE booking SET canceled = 1 WHERE show_date = '$bookingDate' AND show_time = '$bookingTime'";
        if ($conn->query($updateSql) === TRUE) {
            return true;
        } else {
            return false;
        }
    } else {
        return false;
    }
}

// Check if the cancel button is clicked and process the cancellation
if (isset($_POST['cancel_booking'])) {
    $bookingIdToCancel = $_POST['booking_id'];
    if (cancelBooking($conn, $bookingIdToCancel)) {
        $cancellationStatus = 'Booking canceled successfully.';
    } else {
        $cancellationStatus = 'Failed to cancel booking.';
    }
}

// Remove past bookings from the database
$currentDate = date('Y-m-d');
$sql_remove_old_bookings = "DELETE FROM booking WHERE show_date < '$currentDate'";
$conn->query($sql_remove_old_bookings);

// Fetch all the remaining non-canceled bookings for the logged-in user
$sql = "SELECT booking.*, movie.name AS movie_name, COUNT(*) AS num_seats_booked, SUM(price) AS total_price, GROUP_CONCAT(seat_num) AS seat_numbers
        FROM booking
        JOIN movie ON booking.movie_id = movie.id
        WHERE booking.user_id = '$user_id' AND booking.show_date >= CURDATE() AND CONCAT(booking.show_date, ' ', booking.show_time) >= NOW() AND booking.canceled = 0
        GROUP BY CONCAT(booking.show_date, ' ', booking.show_time), booking.movie_id
        ORDER BY booking.show_date DESC, booking.show_time DESC";

$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    echo "<div class='booking-list'>";
    echo "<h2>My Booking List</h2>";

    // Display cancellation status message
    if (!empty($cancellationStatus)) {
        echo "<p class='cancellation-message'>$cancellationStatus</p>";
    }

    echo "<table>";
    echo "<tr>
            <th>Name</th>
            <th>Movie Name</th>
            <th>Show Date</th>
            <th>Show Time</th>
            <th>Seats Booked</th>
            <th>Seat Numbers</th>
            <th>Total Price</th>
            <th>Cancel</th>
            <th>Download Bill</th>
          </tr>";

    // Use an associative array to group bookings by show date, show time, and movie name
    $groupedBookings = [];

    while ($row = $result->fetch_assoc()) {
        $groupKey = $row['show_date'] . ' ' . $row['show_time'] . $row['movie_name'];

        if (!isset($groupedBookings[$groupKey])) {
            $groupedBookings[$groupKey] = [];
        }

        $groupedBookings[$groupKey][] = $row;
    }

    foreach ($groupedBookings as $group) {
        foreach ($group as $row) {
            $bookingId = $row['id'];
            $name = $_SESSION['user_name'];
            $movieName = $row['movie_name'];
            $selectedDate = $row['show_date'];
            $selectedShowTime = $row['show_time'];
            $numSeatsBooked = $row['num_seats_booked'];
            $totalPrice = $row['total_price'];
            $seatNumbers = $row['seat_numbers'];
    
            echo "<tr>
                    <td>$name</td>
                    <td>$movieName</td>
                    <td>$selectedDate</td>
                    <td>$selectedShowTime</td>
                    <td>$numSeatsBooked</td>
                    <td>$seatNumbers</td>
                    <td>$totalPrice</td>
                    
                    <td>
                        <form method='post' action=''>
                            <input type='hidden' name='booking_id' value='$bookingId'>
                            <button type='submit' name='cancel_booking'>Cancel Booking</button>
                        </form>
                    </td>
                    <td>";
    
            // Check if the booking is paid and display appropriate link
            $isPaid = $row['paid'];
    
            // Check if the latest booking for the same movie, date, and time is paid
            $latestBookingSql = "SELECT paid FROM booking WHERE user_id = '$user_id' AND movie_id = '{$row['movie_id']}' AND show_date = '$selectedDate' AND show_time = '$selectedShowTime' AND canceled = 0 ORDER BY booking_date DESC, booking_time DESC LIMIT 1";
            $latestBookingResult = $conn->query($latestBookingSql);
    
            if ($latestBookingResult && $latestBookingResult->num_rows > 0) {
                $latestBookingRow = $latestBookingResult->fetch_assoc();
                $isLatestBookingPaid = $latestBookingRow['paid'];
    
                if ($isPaid && $isLatestBookingPaid) {
                    echo "<a class='download-link' href='downloadbill.php?user_id=$user_id&name=$name&movieName=$movieName&selectedDate=$selectedDate&selectedShowTime=$selectedShowTime&bookedSeats=$numSeatsBooked&totalBookedSeats=$numSeatsBooked&totalAmount=$totalPrice'>Download Bill</a>";
                } else {
                    echo "Please wait for payment confirmation for the latest booking.";
                }
            } else {
                echo "Error fetching latest booking information.";
            }
            echo "</td>
                  </tr>";
        }
    }

    echo "</table>";
    echo "</div>";
} else {
    echo "<p>No upcoming bookings found.</p>";
}

$conn->close();
?>
