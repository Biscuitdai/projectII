<?php
require '../connection.php';
include 'header.php';

session_start();

if (!isset($_SESSION['email'])) {
    header("location:login.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST["id"];
    $sql = "SELECT * FROM movie WHERE id = $id";
    $result = $conn->query($sql);

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
        $price = $row['price'];
        $fdate = $row['first_date'];
        $sdate = $row['second_date'];
        $tdate = $row['third_date'];
        $fshow = $row['first_show'];
        $sshow = $row['second_show'];
        $tshow = $row['third_show'];
        $image = $row['image'];

        if (isset($_POST["update"])) {
            $id = $_POST["id"];
            $name = $_POST["name"];
            $genre = $_POST['genre'];
            $industry = $_POST['industry'];
            $language = $_POST['language'];
            $duration = $_POST['duration'];
            $reldate = $_POST['reldate'];
            $director = $_POST['director'];
            $actor = $_POST['actor'];
            $price = $_POST["price"];
            $fdate = $_POST['first_date'];
            $sdate = $_POST['second_date'];
            $tdate = $_POST['third_date'];
            $fshow = $_POST['first_show'];
            $sshow = $_POST['second_show'];
            $tshow = $_POST['third_show'];

            // Extend show dates by two days after the current date only if the show date is not cleared
            $currentDate = date('Y-m-d');
            $extendedDate = date('Y-m-d', strtotime($currentDate . ' +2 days'));

            // Check if the show date is cleared and update accordingly
            $fdate = ($fdate && $fdate < $currentDate) ? $extendedDate : $fdate;
            $sdate = ($sdate && $sdate < $currentDate) ? $extendedDate : $sdate;
            $tdate = ($tdate && $tdate < $currentDate) ? $extendedDate : $tdate;

            if ($_FILES["image"]["name"]) {
                $file_name = $_FILES["image"]["name"];
                $file_size = $_FILES["image"]["size"];
                $file_tmp = $_FILES["image"]["tmp_name"];
                $file_type = $_FILES["image"]["type"];
                $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

                $allowed_extensions = array("jpg", "jpeg", "png");

                if (in_array($file_ext, $allowed_extensions) && $file_size < 5242880) {
                    $destination = "../images/" . $file_name;

                    if (move_uploaded_file($file_tmp, $destination)) {
                        $image = mysqli_real_escape_string($conn, $file_name);
                        $sql = "UPDATE movie SET name='$name', genre='$genre', industry='$industry', language='$language', movie_duration='$duration', release_date='$reldate', movie_director='$director', actor='$actor', price='$price', first_date='$fdate', second_date='$sdate', third_date='$tdate', first_show='$fshow', second_show='$sshow', third_show='$tshow', image='$image' WHERE id=$id";
                        $result = $conn->query($sql);

                        if ($result) {
                            header("Location: movielist.php");
                            exit;
                        } else {
                            echo '<script type="text/javascript"> alert("Error: ' . $conn->error . '"); </script>';
                        }
                    } else {
                        echo '<script type="text/javascript"> alert("Error moving uploaded file."); </script>';
                    }
                } else {
                    echo '<script type="text/javascript"> alert("Invalid file format or file size exceeds the maximum limit."); </script>';
                }
            } else {
                $sql = "UPDATE movie SET name='$name', genre='$genre', industry='$industry', language='$language', movie_duration='$duration', release_date='$reldate', movie_director='$director', actor='$actor', price='$price', first_date='$fdate', second_date='$sdate', third_date='$tdate', first_show='$fshow', second_show='$sshow', third_show='$tshow' WHERE id=$id";
                $result = $conn->query($sql);

                if ($result) {
                    header("Location: movielist.php");
                    exit;
                } else {
                    echo '<script type="text/javascript"> alert("Error: ' . $conn->error . '"); </script>';
                }
            }
        }
    } else {
        echo "No movie found with ID: $id";
        exit();
    }
}
?>
<link rel="stylesheet" href="edit.css">

<div class="addmovies1">
    <form method="post" action="edit.php" enctype="multipart/form-data">
    <h1>Edit Movie</h1>
    
    <div class="addmovies">
                <div class="left-column">
    <input type="hidden" name="id" value="<?php echo $id; ?>">
        <label for="name">Movie Name:</label>
        <input type="text" name="name" id="name" value="<?php echo $name; ?>" required><br>

        <label for="genre">Genre:</label>
        <input type="text" id="genre" name="genre" value="<?php echo $genre; ?>" required><br>

        <label for="industry">Industry:</label>
        <input type="text" id="industry" name="industry" value="<?php echo $industry; ?>" required><br>

        <label for="language">Language:</label>
        <input type="text" id="language" name="language" value="<?php echo $language; ?>" required><br>

        <label for="duration">Movie Duration:</label>
        <input type="text" id="duration" name="duration" value="<?php echo $duration; ?>" required><br>

        <label for="reldate">Released Date:</label>
        <input type="text" id="reldate" name="reldate" value="<?php echo $reldate; ?>" required><br>

        <label for="director">Director:</label>
        <input type="text" id="director" name="director" value="<?php echo $director; ?>" required><br>

        
        <label for="actor">Actors:</label>
        <input type="text" id="actor" name="actor" value="<?php echo $actor; ?>" required><br>
        </div>

<div class="right-column">
        <label for="price">Price:</label><br>
        <input type="text" name="price" id="price" value="<?php echo $price; ?>" required><br>

        <label for="first_date">First Date:</label>
        <input type="date" id="first_date" name="first_date" value="<?php echo $fdate; ?>" ><br>

        <label for="second_date">Second Date:</label>
        <input type="date" id="second_date" name="second_date" value="<?php echo isset($sdate) ? $sdate : ''; ?>"><br>

        <label for="third_date">Third Date:</label>
        <input type="date" id="third_date" name="third_date" value="<?php echo isset($tdate) ? $tdate : ''; ?>" ><br>

        <label for="first_show">First Show</label>
        <input type="time" name="first_show" id="first_show" value="<?php echo $fshow; ?>" ><br>

        <label for="second_show">Second Show:</label>
        <input type="time" name="second_show" id="second_show" value="<?php echo isset($sshow) ? $sshow : ''; ?>" ><br>

        <label for="third_show">Third Show:</label>
        <input type="time" name="third_show" id="third_show" value="<?php echo isset($tshow) ? $tshow : ''; ?>" ><br>

        <label for="image">Movie Poster Image:</label>
        <input type="file" id="image" name="image"><br>
        </div>
            </div>
            
        
        <div class="button">
        <input type="submit" name="update" value="Update" class="btn">
        </div>
    </form>
</div>
</div>
