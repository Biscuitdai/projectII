<?php
require '../connection.php';
include 'header.php';
session_start();
if(!isset($_SESSION['email']))
{
    header("location:login.php");
    exit;
}

?>
<link rel="stylesheet" href="movielist.css">

<h2 class="h2">Movie List</h2>

<table class="edit-delete-table">
  <tr>
    <th>ID</th>
    <th>Movie Name</th>
    <th>Genre</th>
        <th>Industry</th>
      <th>Language</th>
        <th>Duration</th>
        <th>Reldate</th>
        <th>Director</th>
        <th>Actor</th>
    <th>Price</th>
    <th>F_DATE</th>
    <th>S_DATE</th>
    <th>T_DATE</th>
    <th>F_SHOW</th>
    <th>S_SHOW</th>
    <th>T_SHOW</th>
    <th>Image</th>
    <th>Action</th>
  </tr>

  <?php
  $conn = new mysqli("localhost", "root", "", "movieproject");
  if ($conn->connect_error) {
    die("Connection error: " . $conn->connect_error);
  }

  $sql = "SELECT * FROM movie";
  $result = $conn->query($sql);

  if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      $id = $row['id'];
      $name = $row['name'];
      $genre = $row['genre'];
    $industry = $row['industry'];
    $language = $row['language'];
    $duration = $row['movie_duration'];
    $reldate = $row['release_date'];
    $director = $row['movie_director'];
    $actor = $row['actor'];
      $price = $row['price'];
      $image = $row['image'];
      $fdate = $row['first_date'];
      $sdate = $row['second_date'];
      $tdate = $row['third_date'];
      $fshow = $row['first_show'];
      $sshow = $row['second_show'];
      $tshow = $row['third_show'];

      echo "
      <tr>
        <td>$id</td>
        <td>$name</td>
        <td>$genre</td>
        <td>$industry</td>
        <td>$language</td>
        <td>$duration</td>
        <td>$reldate</td>
        <td>$director</td>
        <td>$actor</td>
        <td>$price</td>
        <td>$fdate</td>
        <td>$sdate</td>
        <td>$tdate</td>
        <td>$fshow</td>
        <td>$sshow</td>
        <td>$tshow</td>
        
        <td ><img src='../../images/$image' style='width: 110px; height: 50px' alt='Movie Poster'></td>
        <td>
          <form action='edit.php' method='POST'>
            <input type='hidden' name='id' value='$id'>
            <input type='submit' class='edit-button' value='Edit'>
          </form>
          <form action='delete.php' method='POST'>
            <input type='hidden' name='id' value='$id'>
            <input type='submit'   class='delete-button' value='Delete'>
          </form>
        </td>
      </tr>
      ";
    }
  } else {
    echo "<tr><td colspan='6'>No movies found</td></tr>";
  }

  $conn->close();
  ?>
</table>
