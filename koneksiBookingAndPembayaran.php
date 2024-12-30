<?php
session_start();
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Koneksi ke database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "pwd_responsi"; // Nama database Anda

$conn = new mysqli($servername, $username, $password, $dbname);

// Cek koneksi
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Cek apakah data form ada di POST
if (isset($_POST['selected_seats'], $_POST['ticket_count'], $_POST['booking_date'], $_POST['booking_time'])) {

    // Ambil data dari form
    $selected_seats = $_POST['selected_seats']; // Kursi yang dipilih dari form (format: "A5, A6")
    $ticket_count = $_POST['ticket_count']; // Jumlah tiket dari form
    $price_per_ticket = 50000; // Harga per tiket
    $total_price = $ticket_count * $price_per_ticket; // Total harga
    $booking_date = $_POST['booking_date']; // Tanggal booking dari form
    $booking_time = $_POST['booking_time']; // Waktu booking dari form

    // Cek jika ada nilai kosong atau tidak valid
    if (empty($selected_seats) || empty($ticket_count) || empty($booking_date) || empty($booking_time)) {
        echo "Form belum lengkap. Pastikan semua data sudah diisi.";
        exit;
    }
    // Menyimpan data ke tabel bookingFilm
    $sql_booking = "INSERT INTO bookingFilm (selected_seats, ticket_count, price, booking_date, booking_time)
                    VALUES (?, ?, ?, ?, ?)";
    $stmt_booking = $conn->prepare($sql_booking);
    $stmt_booking->bind_param("sisss", $selected_seats, $ticket_count, $total_price, $booking_date, $booking_time);

    if ($stmt_booking->execute()) {
        // Ambil data booking terakhir
        $last_id = $conn->insert_id;
        $sql_get_booking = "SELECT * FROM bookingFilm WHERE id = ?";
        $stmt_get_booking = $conn->prepare($sql_get_booking);
        $stmt_get_booking->bind_param("i", $last_id);
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
        echo "Error: " . $stmt_booking->error;
    }
} else {
    // Tampilkan error jika ada data yang hilang
    echo "Form belum lengkap. Pastikan semua data sudah diisi.";
}

// Tutup koneksi
$conn->close();
