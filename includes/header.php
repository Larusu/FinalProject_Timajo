<?php
require_once '../helpers/auth.php';
require_login();

if (isset($_SESSION['messages'])) {
    echo '<div class="message-container">';
    foreach ($_SESSION['messages'] as $msg) {
        echo '<div class="message"><span>' . htmlspecialchars($msg) . '</span></div>';
    }
    echo '</div>';
    unset($_SESSION['messages']);
}
?>

<header class="main-header">
    <div class="header-content">
        <div class="logo">Mr. Budget</div>
        <nav class="nav-links">
            <a href="../dashboard/profile.php">Profile</a>
            <a href="../auth/logout.php">Logout</a>
        </nav>
    </div>
</header>
