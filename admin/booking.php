<?php
include 'header.php';
require '../connection.php';
session_start();

if (!isset($_SESSION['email'])) {
    header("location:login.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['mark_paid'])) {
        $bookingId = $_POST['booking_id'];
        $booking_date = $_POST['booking_date'];
        $booking_time = $_POST['booking_time'];

        // Update the paid status in the database using prepared statement
        $updateSql = "UPDATE booking SET paid = 1 WHERE booking_date=? AND booking_time=?";
        $stmt = $conn->prepare($updateSql);
        $stmt->bind_param("ss", $booking_date, $booking_time);
        $stmt->execute();
    } elseif (isset($_POST['delete_booking'])) {
        $bookingId = $_POST['booking_id'];

        // Retrieve information about the booking before deletion
        $selectSql = "SELECT * FROM booking WHERE id = ?";
        $stmt = $conn->prepare($selectSql);

        if (!$stmt) {
            die("Error in query preparation: " . $conn->error);
        }

        $stmt->bind_param("i", $bookingId);
        $stmt->execute();

        $result = $stmt->get_result();

        if (!$result) {
            die("Error in query execution: " . $stmt->error);
        }

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $deletedSeats = $row['num_seats_booked'];  // Use the correct column name
            $booking_date = $row['booking_date'];
            $booking_time = $row['booking_time'];

            // Delete the booking from the database using prepared statement
            $deleteSql = "DELETE FROM booking WHERE id = ?";
            $stmtDelete = $conn->prepare($deleteSql);

            if (!$stmtDelete) {
                die("Error in query preparation: " . $conn->error);
            }

            $stmtDelete->bind_param("i", $bookingId);
            $stmtDelete->execute();

            if ($deletedSeats > 0) {
                // Calculate the new total price based on the remaining seats
                $updateSql = "UPDATE booking SET total_price = total_price - (? * seat_price) WHERE booking_date=? AND booking_time=?";
                $stmtUpdate = $conn->prepare($updateSql);

                if (!$stmtUpdate) {
                    die("Error in query preparation: " . $conn->error);
                }

                $stmtUpdate->bind_param("iss", $deletedSeats, $booking_date, $booking_time);
                $stmtUpdate->execute();
            }
        }
    }

    // Redirect to the same page to prevent form resubmission
    header("Location: $_SERVER[PHP_SELF]");
    exit;
}

// Your existing SQL query remains unchanged
$sql = "SELECT booking.*, movie.name AS movie_name, GROUP_CONCAT(seat_num ORDER BY seat_num) AS seat_numbers, COUNT(*) AS num_seats_booked, user.name AS user_name, canceled
FROM booking
JOIN movie ON booking.movie_id = movie.id
JOIN user ON booking.user_id = user.id
GROUP BY booking_date, booking_time, user.id
ORDER BY booking_date DESC, booking_time DESC
";

$result = $conn->query($sql);

if (!$result) {
    die("SQL Error: " . $conn->error);
}

if ($result->num_rows > 0) {
    echo "<div class='booking-list'>";
    echo "<h2>Booking List</h2>";

    echo "<form method='post'>";
    echo "<table>";
    echo "<tr>
            <th>Name</th>
            <th>Movie Name</th>
            <th>Show Date</th>
            <th>Show Time</th>
            <th>Seats Booked</th>
            <th>Total Price</th>
            <th>Paid Status</th>
            <th>Action</th>
            <th>Payments</th>
            <th>Canceled</th>
          </tr>";

    while ($row = $result->fetch_assoc()) {
        $name = $row['user_name'];
        $imgname = $row['image_path'];
        $movieName = $row['movie_name'];
        $showDate = date('F j, Y', strtotime($row['show_date'])); // Format the date
        $showTime = date('h:i A', strtotime($row['show_time'])); // Format the time
        $seatNumbers = $row['seat_numbers'];
        $numSeatsBooked = $row['num_seats_booked'];
        $totalPrice = $row['total_price'];
        $paid = $row['paid'];

        echo "<tr>
                <td>$name</td>
                <td>$movieName</td>
                <td>$showDate</td>
                <td>$showTime</td>
                <td>$seatNumbers</td>
                <td>$totalPrice</td>
                <td id='paid-status-{$row['id']}'>" . ($paid ? 'Paid' : 'Not Paid') . "</td>
                <td>
                    <form method='post'>
                        <input type='hidden' name='booking_id' value='{$row['id']}'>
                        <input type='hidden' name='booking_date' value='{$row['booking_date']}'>
                        <input type='hidden' name='booking_time' value='{$row['booking_time']}'>
                        <input type='submit' name='mark_paid' value='Mark as Paid'>
                        <input type='submit' name='delete_booking' value='Delete booked'>
                    </form>
                </td>
                <td><img src='../uploads/$imgname' style='height:100px; width:100px;' id='jsuse'></td>
                <td>" . ($row['canceled'] ? 'Yes' : 'No') . "</td>
              </tr>";
    }

    echo "</table>";
    echo "</form>";
    echo "</div>";
} else {
    echo "No bookings found.";
}

$conn->close();
?>

<link rel="stylesheet" href="booking.css">

<script>
var img = document.getElementsByTagName('img');

for (var i = 0; i < img.length; i++) {
    img[i].onclick = function() {
        this.style.height = '350px';
        this.style.width = '700px';
    };

    img[i].onmouseout = function() {
        this.style.height = '100px';
        this.style.width = '100px';
    };
}
</script>
