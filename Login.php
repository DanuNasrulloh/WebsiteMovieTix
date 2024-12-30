<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: ../HTML/HtmlLogin.html");
    exit();
}
if (isset($_GET['error']) && $_GET['error'] == 'invalid_credentials') {
    echo '<div class="alert alert-danger" role="alert">Username atau password salah. Silakan coba lagi.</div>';
}
