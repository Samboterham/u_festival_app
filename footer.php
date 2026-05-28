<?php
$current_page = basename($_SERVER['PHP_SELF']);
?>

<nav class="nav-menu" aria-label="Hoofdnavigatie">
    <a href="index.php" class="nav-btn <?php echo ($current_page == 'index.php') ? 'active' : ''; ?>" aria-label="Home">
        <img class="icons" src="images/home-black.png" alt="">
    </a>
    <a href="info.php" class="nav-btn <?php echo ($current_page == 'info.php') ? 'active' : ''; ?>" aria-label="Info">
        <img class="icons" src="images/info-black.png" alt="">
    </a>
    <a href="lineup.php" class="nav-btn <?php echo ($current_page == 'lineup.php') ? 'active' : ''; ?>" aria-label="Line-up">
        <img class="icons" src="images/music-black.png" alt="">
    </a>
    <a href="map.php" class="nav-btn <?php echo ($current_page == 'map.php') ? 'active' : ''; ?>" aria-label="Kaart">
        <img class="icons" src="images/pin-black.png" alt="">
    </a>
</nav>
