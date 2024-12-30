<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "pwd_responsi";

// Buat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

// Periksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Ambil data kursi dari permintaan
$data = json_decode(file_get_contents('php://input'), true);
$selectedSeats = $data['seats'] ?? [];

if (!empty($selectedSeats)) {
    foreach ($selectedSeats as $seat) {
        $stmt = $conn->prepare("INSERT INTO seats (seat_number) VALUES (?)");
        $stmt->bind_param("s", $seat);
        $stmt->execute();
    }
    echo json_encode(["message" => "Kursi berhasil disimpan"]);
} else {
    echo json_encode(["message" => "Tidak ada kursi yang dipilih"]);
}

$conn->close();
