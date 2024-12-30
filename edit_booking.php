<?php
session_start();
ini_set('display_errors', 1);
error_reporting(E_ALL);
// Cek apakah ada parameter id
if (isset($_GET['id'])) {
    $booking_id = $_GET['id'];
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "pwd_responsi"; // Nama database Anda

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $sql_get_booking = "SELECT * FROM bookingFilm WHERE id = ?";
    $stmt_get_booking = $conn->prepare($sql_get_booking);
    $stmt_get_booking->bind_param("i", $booking_id);
    $stmt_get_booking->execute();
    $result_get_booking = $stmt_get_booking->get_result();

    if ($result_get_booking->num_rows > 0) {
        $booking = $result_get_booking->fetch_assoc();
    } else {
        echo "Data tidak ditemukan";
        exit;
    }

    $conn->close();

?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Edit Booking</title>
        <link href="../CSS/TestCSSedit.css" rel="stylesheet">
    </head>

    <body>
        <nav class="navbar">
            <div class="navbar-container">
                <a href="#" class="navbar-logo">Jurassic World</a>
                <ul class="navbar-menu">
                    <li class="navbar-item"><a href="../HTML/Home.html" class="navbar-link">Home</a></li>
                    <li class="navbar-item"><a href="#" class="navbar-link">Services</a></li>
                    <li class="navbar-item"><a href="#" class="navbar-link">logout</a></li>
                </ul>
            </div>
        </nav>
        <div class="container">
            <h1>Edit Booking</h1>
            <form method="POST" action="update_booking.php">
                <input type="hidden" name="id" value="<?php echo htmlspecialchars($booking['id']); ?>">
                <div class="booking-section">
                    <h3>Nomor kursi</h3>
                    <input type="text" name="selected_seats" value="<?php echo isset($booking['selected_seats']) ? htmlspecialchars($booking['selected_seats']) : ''; ?>" style="width: 100%; padding: 8px;" required>
                </div>

                <div class="booking-section">
                    <h3>Jumlah Tiket</h3>
                    <input type="number" name="ticket_count" value="<?php echo isset($booking['ticket_count']) ? htmlspecialchars($booking['ticket_count']) : ''; ?>" min="1" style="width: 100%; padding: 8px;" required>
                </div>

                <div class="booking-section">
                    <h3>Tanggal</h3>
                    <input type="date" name="booking_date" value="<?php echo isset($booking['booking_date']) ? htmlspecialchars($booking['booking_date']) : ''; ?>" style="width: 100%; padding: 8px;" required>
                </div>

                <!-- HTML -->
                <div class="time-selector">
                    <h3>Pilih waktu</h3>
                    <div class="time-options">
                        <input type="radio" id="time-1000" name="booking_time" value="10:00" required>
                        <label for="time-1000">10:00</label>

                        <input type="radio" id="time-1230" name="booking_time" value="12:30">
                        <label for="time-1230">12:30</label>

                        <input type="radio" id="time-1500" name="booking_time" value="15:00">
                        <label for="time-1500">15:00</label>

                        <input type="radio" id="time-1730" name="booking_time" value="17:30">
                        <label for="time-1730">17:30</label>

                        <input type="radio" id="time-2000" name="booking_time" value="20:00">
                        <label for="time-2000">20:00</label>

                        <input type="radio" id="time-2230" name="booking_time" value="22:30">
                        <label for="time-2230">22:30</label>
                    </div>
                </div>

                <button type="submit" class="button">Update Booking</button>
            </form>
        </div>
        <footer class="footer">
            <div class="footer-container">
                <p>&copy; 2024 Jurassic World. Danu Nasrulloh.</p>
                <ul class="footer-menu">
                    <li class="footer-item"><a href="#" class="footer-link">Privacy Policy</a></li>
                    <li class="footer-item"><a href="#" class="footer-link">Terms of Service</a></li>
                    <li class="footer-item"><a href="#" class="footer-link">Contact Us</a></li>
                </ul>
            </div>
        </footer>
    </body>

    </html>
<?php

} else {
    echo "ID Booking tidak ditemukan";
}
?>