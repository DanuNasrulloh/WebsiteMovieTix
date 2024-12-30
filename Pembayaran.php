<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran</title>
    <link rel="stylesheet" href="../CSS/stylecssPembayaran.css">

</head>

<body>

    <nav class="navbar">
        <div class="navbar-container">
            <a href="#" class="navbar-logo">Jurassic World</a>
            <ul class="navbar-menu">
                <li class="navbar-item"><a href="../HTML/Home.html" class="navbar-link">Home</a></li>
                <li class="navbar-item"><a href="#" class="navbar-link">Services</a></li>
                <li class="navbar-item"><a href="#" class="navbar-link" id="logoutButton">Logout</a></li>
            </ul>
        </div>
    </nav>

    <div class="container">
        <h1>Pembayaran</h1>
        <a href="../PHP/cetak_pdf.php" class="button">Cetak Struck</a>
        <table>
            <tr>
                <th>Nomor kursi</th>
                <th>Jumlah tiket</th>
                <th>Edit</th>
                <th>Hapus</th>
            </tr>
            <?php
            session_start();

            if (isset($_SESSION['booking_data'])) {
                $booking = $_SESSION['booking_data'];
                echo "<tr>";
                echo "<td>" . htmlspecialchars($booking['selected_seats']) . "</td>";
                echo "<td>" . htmlspecialchars($booking['ticket_count']) . "</td>";
                echo "<td><a href='../PHP/edit_booking.php?id=" . htmlspecialchars($booking['id']) . "'><button>Edit</button></a></td>";
                echo "<td><a href='../PHP/delete_booking.php?id=" . htmlspecialchars($booking['id']) . "' onclick='return confirm(\"Apakah Anda yakin ingin menghapus pesanan ini?\")'><button>Hapus</button></a></td>";
                echo "</tr>";
                // Hapus unset($_SESSION['booking_data']); agar data tetap tersimpan untuk cetak PDF
            }

            ?>
        </table>

        <h2>Harga tiket</h2>
        <p>Harga tiket: Rp 50.000</p>
        <p>Jumlah: <?php if (isset($booking)) {
                        echo htmlspecialchars($booking['ticket_count']);
                    } ?></p>
        <p>Total Harga: <?php if (isset($booking)) {
                            echo "Rp " . htmlspecialchars($booking['ticket_count'] * 50000);
                        } ?> </p>

        <h2>QRIS</h2>
        <div class="qris">
            <img src="../IMAGE/contohqris.jpg" alt="gambar qris">
        </div>
    </div>

    <footer class="footer">
        <div class="footer-container">
            <p>&copy; 2024 Jurassic World. Danu Nasrulloh.</p>
            <ul class="footer-menu">
                <li class="footer-item"><a href="#" class="footer-link">Privacy Policy</a></li>
                <li class="footer-item"><a href="#" class="footer-link">Terms of Service</a></li>
                <li class="footer-item"><a href="https://www.instagram.com/iceoo0509/" class="footer-link">Contact Us : IG-Danu Nasrulloh</a></li>
            </ul>
        </div>
    </footer>
    <script src="../JS/logout.js"></script>
</body>

</html>