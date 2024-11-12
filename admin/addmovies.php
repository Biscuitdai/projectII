<?php
require '../connection.php';
include 'header.php';
session_start();
if (!isset($_SESSION['email'])) {
    header("location:login.php");
    exit;
}

if (isset($_POST['add'])) {
    $name = $_POST['name'];
    $genre = $_POST['genre'];
    $industry = $_POST['industry'];
    $duration = $_POST['duration'];
    $language = $_POST['language'];
    $reldate = $_POST['reldate'];
    $director = $_POST['director'];
    $actor = $_POST['actor'];
    $price = $_POST['price'];
    $fshow = isset($_POST['fshow']) ? $_POST['fshow'] : null;
    $sshow = isset($_POST['sshow']) ? $_POST['sshow'] : null;
    $tshow = isset($_POST['tshow']) ? $_POST['tshow'] : null;
    $fdate = isset($_POST['fdate']) ? date('Y-m-d', strtotime($_POST['fdate'])) : null;
    $sdate = isset($_POST['sdate']) ? date('Y-m-d', strtotime($_POST['sdate'])) : null;
    $tdate = isset($_POST['tdate']) ? date('Y-m-d', strtotime($_POST['tdate'])) : null;

    // Extend show dates by two days after the current date
    $currentDate = date('Y-m-d');
    $extendedDate = date('Y-m-d', strtotime($currentDate . ' +2 days'));

    if ($fdate < $currentDate) {
        $fdate = $extendedDate;
    }

    if ($sdate < $currentDate) {
        $sdate = $extendedDate;
    }

    if ($tdate < $currentDate) {
        $tdate = $extendedDate;
    }

    if ($_FILES["image"]["name"]) {
        $file_name = $_FILES["image"]["name"];
        $file_size = $_FILES["image"]["size"];
        $file_tmp = $_FILES["image"]["tmp_name"];
        $file_type = $_FILES["image"]["type"];
        $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

        $allowed_extensions = array("jpg", "jpeg", "png"); // Add any additional allowed extensions here

        if (in_array($file_ext, $allowed_extensions)) {
            if ($file_size < 5242880) { // Max file size: 5MB (you can adjust this value)
                $destination = "../images/" . $file_name;

                if (move_uploaded_file($file_tmp, $destination)) {
                    $image = mysqli_real_escape_string($conn, $destination);

                    $sql = "INSERT INTO movie (name, genre, industry, language, movie_duration, release_date, movie_director, actor, price, image, first_show, second_show, third_show, first_date, second_date, third_date) 
                    VALUES ('$name', '$genre', '$industry', '$language', '$duration', '$reldate', '$director', '$actor', '$price', '$file_name', '$fshow', '$sshow', '$tshow', '$fdate', '$sdate', '$tdate')";

                    $result = $conn->query($sql);

                    if ($result) {
                        echo '<script type="text/javascript"> alert("Movie added successfully."); </script>';
                        header("Location: movielist.php");
                        exit;
                    } else {
                        echo '<script type="text/javascript"> alert("Error: ' . $conn->error . '"); </script>';
                    }
                } else {
                    echo '<script type="text/javascript"> alert("Error moving uploaded file."); </script>';
                }
            } else {
                echo '<script type="text/javascript"> alert("File size exceeds the maximum limit."); </script>';
            }
        } else {
            echo '<script type="text/javascript"> alert("Invalid file format. Only JPG, JPEG, and PNG files are allowed."); </script>';
        }
    } else {
        // Insert data into the database without an image
        $sql = "INSERT INTO movie (name, genre, industry, language, movie_duration, release_date, movie_director, actor, price, first_show, second_show, third_show, first_date, second_date, third_date) 
        VALUES ('$name', '$genre', '$industry', '$language', '$duration', '$reldate', '$director', '$actor', '$price', '$fshow', '$sshow', '$tshow', '$fdate', '$sdate', '$tdate')";

        $result = $conn->query($sql);

        if ($result) {
            echo '<script type="text/javascript"> alert("Movie added successfully."); </script>';
            header("Location: movielist.php");
            exit;
        } else {
            echo '<script type="text/javascript"> alert("Error: ' . $conn->error . '"); </script>';
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Movie</title>
    <link rel="stylesheet" href="addmovies.css">
</head>
<body>
    <div class="addmovies1">
        <form action="" method="POST" enctype="multipart/form-data">
            <h1>Add Movie</h1>

            <div class="addmovies">
                <div class="left-column">
                    <!-- Left side form elements -->
                    <label for="name">Movie Name:</label><br>
                    <input type="text" id="name" name="name" placeholder="Enter Movie Name"><br>

                    <label for="genre">Genre:</label><br>
                    <input type="text" id="genre" name="genre"><br>

                    <label for="industry">Industry:</label><br>
                    <input type="text" id="industry" name="industry"><br>

                    <label for="language">Language:</label><br>
                    <input type="text" id="language" name="language"><br>

                    <label for="duration">Movie Duration:</label><br>
                    <input type="text" id="duration" name="duration"><br>

                    <label for="reldate">Released Date:</label><br>
                    <input type="text" id="reldate" name="reldate"><br>

                    <label for="director">Director:</label><br>
                    <input type="text" id="director" name="director"><br>

                    <label for="actor">Actors:</label><br>
                    <input type="text" id="actor" name="actor"><br>
                </div>

                <div class="right-column">
                    <!-- Right side form elements -->
                    <label for="price">Ticket Price:</label><br>
                    <input type="number" id="price" name="price"><br>

                    <label for="fshow">First Show:</label><br>
                    <input type="time" id="fshow" name="fshow"><br>

                    <label for="sshow">Second Show:</label><br>
                    <input type="time" id="sshow" name="sshow"><br>

                    <label for="tshow">Third Show:</label><br>
                    <input type="time" id="tshow" name="tshow"><br>

                    <label for="fdate">First Show Date:</label><br>
                    <input type="date" id="fdate" name="fdate"><br>

                    <label for="sdate">Second Show Date:</label><br>
                    <input type="date" id="sdate" name="sdate"><br>

                    <label for="tdate">Third Show Date:</label><br>
                    <input type="date" id="tdate" name="tdate"><br>

                    <label for="image">Movie Poster Image:</label><br>
                    <input type="file" id="image" name="image"><br>
                </div>
            </div>

            <div class="button">
                <input type="submit" value="Add Movie" name="add" class="btn">
            </div>
        </form>
    </div>
</body>
</html>
