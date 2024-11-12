
<link rel="stylesheet" href="header.css">
    <nav>
        <div>
            <a href="index.php" class="container-a"><p>Movie World</p></a>
        </div>
        <div>
            <ul class="head-list">
            <a href="index.php" class="menu-link container-li">Movies</a>
                
          

    <?php
    session_start();
    if (isset($_SESSION['email']) && isset($_SESSION['user_id']) && isset($_SESSION['user_name']))    {
    echo '<li>
    <li><a href="mybookings.php" class="container-li">My Bookings</a></li>
    <a href = logout.php class="container-li">Logout</a>
    </li>';
}else {
            
    echo '<li class="menu-item">
    <a href="login.php" class="menu-link container-li">Login</a>
            <a href="register.php" class="menu-link container-li">Register</a>
          </li>';
}

    ?>
      </ul>
        </div>
    </nav>
