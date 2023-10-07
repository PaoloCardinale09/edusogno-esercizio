<?php session_start(); ?>
<header>
    <div class="logo">
        <a href="./index.php"><img id="logo" src="./assets/img/logo.svg" alt="logo"></a>
    </div>
    <?php if (isset($_SESSION['user_id'])): ?>
    <div class="user-info">
        <span>
            <?php echo $_SESSION['user_name'] . ' ' . $_SESSION['user_surname']; ?>
        </span>
        <div id="logoutButtonContainer">
            <a href="./assets/partials/logout.php" class="logout-button">Logout</a>
        </div>
    </div>
    <?php endif; ?>
</header>