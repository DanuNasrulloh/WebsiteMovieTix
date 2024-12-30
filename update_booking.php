<?php
session_start();
ini_set('display_errors', 1);
error_reporting(E_ALL);

if (isset($_POST['id'], $_POST['selected_seats'], $_POST['ticket_count'], $_POST['booking_date'], $_POST['booking_time'])) {
    $booking_id = (int)$_POST['id'];
    $selected_seats = $_POST['selected_seats'];
    $ticket_count = (int)$_POST['ticket_count'];
    $booking_date = $_POST['booking_date'];
    $booking_time = $_POST['booking_time'];

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "pwd_responsi"; // Nama database Anda

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $sql_update_booking = "UPDATE bookingFilm SET selected_seats = ?, ticket_count = ?, booking_date = ?, booking_time = ? WHERE id = ?";
    $stmt_update_booking = $conn->prepare($sql_update_booking);
    $stmt_update_booking->bind_param("sissi", $selected_seats, $ticket_count, $booking_date, $booking_time, $booking_id);
    if ($stmt_update_booking->execute()) {
        // Ambil data booking terbaru
        $sql_get_booking = "SELECT * FROM bookingFilm WHERE id = ?";
        $stmt_get_booking = $conn->prepare($sql_get_booking);
        $stmt_get_booking->bind_param("i", $booking_id);
        $stmt_get_booking->execute();
        $result_get_booking = $stmt_get_booking->get_result();
        $booking_data = $result_get_booking->fetch_assoc();

        // Simpan data booking ke dalam session
        $_SESSION['booking_data'] = $booking_data;


        // Redirect ke halaman pembayaran setelah booking berhasil disimpan
        $params = http_build_query($_SESSION);
        header("Location: ../HTML/pembayaran.php?" . $params);
        exit;
    } else {
        echo "Error " . $stmt_update_booking->error;
    }
    $conn->close();
} else {
    echo "Form tidak lengkap";
}
