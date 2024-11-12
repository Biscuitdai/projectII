<?php
include('header.php');
require '../connection.php';
?>

<link rel="stylesheet" href="user.css">
<h2 class="h2">User List</h2>

<table class="edit-delete-table">
  <tr>
    <th>User ID</th>
    <th>User Name</th>
    <th>Email</th>
    <th>Phone Number</th>
  </tr>
  <?php
 
  $sql = "SELECT * FROM user";
  $result = $conn->query($sql);

  if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      $id = $row['id'];
      $name = $row['name'];

      $email = $row['email'];
      $phone = $row['phone_no'];
      echo "
      <tr>
        <td>$id</td>
        <td>$name</td>
        <td>$email</td>
        <td>$phone</td>
      </tr>
      ";
    }
  } else {
    echo "<tr><td colspan='4'>No users found</td></tr>";
  }

  $conn->close();
  ?>
</table>



</body>
</html>
