<?php
require '../connection.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST["id"];
  
    // Delete the movie from the database
    $sql = "DELETE FROM movie WHERE id = $id";
  
    if ($conn->query($sql) === TRUE) {
      header("location:movielist.php");
    } else {
      echo "Error deleting movie: " . $conn->error;
    }
  }
?>
<?php
session_start();
if(!isset(  $_SESSION['email'] ))
{
    header("location:login.php");
}

?>