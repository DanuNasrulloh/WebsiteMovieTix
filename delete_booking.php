<?php
session_start();
require_once 'koneksi.php'; // Include database connection

if (isset($_GET['id']) && isset($_SESSION['booking_data'])) {
    // Clear the booking data from session
    unset($_SESSION['booking_data']);

    // Redirect back to pembayaran page
    header("Location: ../HTML/Pembayaran.php");
    exit();
}


$booking_id = $_GET['id'];

// Query DELETE dengan prepared statement
$sql_delete_booking = "DELETE FROM bookingFilm WHERE id = ?";
$stmt_delete_booking = $conn->prepare($sql_delete_booking);

if ($stmt_delete_booking) {
    // Bind parameter untuk query
    $stmt_delete_booking->bind_param("i", $booking_id);

    // Eksekusi query
    if ($stmt_delete_booking->execute()) {
        // Cek apakah ada baris yang terpengaruh
        if ($stmt_delete_booking->affected_rows > 0) {
            $_SESSION['success'] = "Data booking berhasil dihapus";
        } else {
            $_SESSION['error'] = "Data booking tidak ditemukan";
        }
    } else {
        $_SESSION['error'] = "Error saat menghapus data: " . $stmt_delete_booking->error;
    }

    $stmt_delete_booking->close();
} else {
    $_SESSION['error'] = "Error pada prepare statement: " . $conn->error;
}

$conn->close();

// Redirect back
header("Location: ../HTML/Pembayaran.php");
exit();
