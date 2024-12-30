<?php
session_start();

if (!file_exists('../fpdf/fpdf.php')) {
    die("Error: FPDF library tidak ditemukan. Pastikan library sudah terinstall dengan benar.");
}

if (!isset($_SESSION['booking_data'])) {
    die("Error: Data booking tidak ditemukan. Silakan lakukan pemesanan terlebih dahulu.");
}

require 'koneksi.php';
require('../fpdf/fpdf.php');

$booking = $_SESSION['booking_data'];

class ReceiptPDF extends FPDF
{
    function Header()
    {
        // Logo (sesuaikan path dengan logo Anda)
        // $this->Image('logo.png', 10, 10, 30);

        // Header Border
        $this->SetFillColor(26, 26, 26); // Dark background
        $this->Rect(0, 0, 210, 40, 'F');

        // Title
        $this->SetFont('Arial', 'B', 24);
        $this->SetTextColor(255, 255, 255);
        $this->Cell(0, 25, 'JURASSIC WORLD', 0, 1, 'C');
        $this->SetFont('Arial', '', 12);
        $this->Cell(0, 0, 'E-Ticket Receipt', 0, 1, 'C');

        // Reset text color
        $this->SetTextColor(0, 0, 0);
        $this->Ln(20);
    }

    function Footer()
    {
        $this->SetY(-30);
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 10, 'Page ' . $this->PageNo() . '/{nb}', 0, 0, 'C');
    }
}

// Instantiate PDF
$pdf = new ReceiptPDF('P', 'mm', 'A4');
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetMargins(20, 20, 20);

// Booking Information Box
$pdf->SetFont('Arial', 'B', 14);
$pdf->Cell(0, 10, 'BOOKING DETAILS', 1, 1, 'C', true);
$pdf->SetFont('Arial', '', 12);
$pdf->Ln(5);

// Create two-column layout
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(95, 10, 'Transaction Information', 0, 0);
$pdf->Cell(95, 10, 'Ticket Information', 0, 1);

$pdf->SetFont('Arial', '', 10);
$pdf->Line(20, $pdf->GetY(), 190, $pdf->GetY());
$pdf->Ln(5);

// Left Column
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(40, 7, 'Booking ID:', 0);
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(55, 7, '#' . str_pad($booking['id'], 6, '0', STR_PAD_LEFT), 0, 0);

// Right Column
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(40, 7, 'Show Date:', 0);
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(55, 7, date('d-m-Y', strtotime($booking['booking_date'])), 0, 1);

// Continue with more rows
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(40, 7, 'Time:', 0);
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(55, 7, $booking['booking_time'], 0, 0);

$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(40, 7, 'Seat Number:', 0);
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(55, 7, $booking['selected_seats'], 0, 1);

$pdf->Ln(10);

// Price Details Box
$pdf->SetFillColor(240, 240, 240);
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(0, 10, 'PRICE DETAILS', 1, 1, 'C', true);
$pdf->SetFont('Arial', '', 10);

// Price Table
$pdf->SetFillColor(245, 245, 245);
$pdf->Cell(90, 8, 'Description', 1, 0, 'L', true);
$pdf->Cell(40, 8, 'Quantity', 1, 0, 'C', true);
$pdf->Cell(40, 8, 'Amount', 1, 1, 'R', true);

$pdf->Cell(90, 8, 'Movie Ticket', 1);
$pdf->Cell(40, 8, $booking['ticket_count'], 1, 0, 'C');
$pdf->Cell(40, 8, 'Rp 50.000', 1, 1, 'R');

$total = $booking['ticket_count'] * 50000;
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(130, 8, 'Total Amount', 1, 0, 'L', true);
$pdf->Cell(40, 8, 'Rp ' . number_format($total, 0, ',', '.'), 1, 1, 'R', true);

$pdf->Ln(10);

// Terms and Conditions
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(0, 8, 'Terms & Conditions:', 0, 1);
$pdf->SetFont('Arial', '', 9);
$pdf->MultiCell(0, 5, '1. Tiket tidak dapat dikembalikan atau ditukar
2. Harap tiba 30 menit sebelum waktu pemutaran
3. Tunjukkan e-ticket ini kepada petugas saat memasuki studio
4. Tempat duduk sesuai dengan nomor yang tertera pada tiket');

// QR Code placeholder
$pdf->Ln(10);
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(0, 10, 'SCAN HERE', 0, 1, 'C');
// Add QR Code here if needed
// $pdf->Image('qr_code.png', 85, $pdf->GetY(), 40);

// Output PDF
$pdf->Output('I', 'Struk_Tiket_Film.pdf');
