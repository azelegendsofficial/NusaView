<?php
// dashboard-auth-check.php - Include this at the top of dashboard.html
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: index.html');
    exit;
}
?>
