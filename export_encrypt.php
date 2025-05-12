<?php
session_start();
require_once 'db.php';
require_once 'fpdf/fpdf.php';
if (!isset($_SESSION['username'])) {
    exit("Brak dostępu.");
}

$username = $_SESSION['username'];
$stmt = $conn->prepare("SELECT * FROM encrypted_data WHERE username = ? ORDER BY timestamp DESC");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 14);
$pdf->Cell(0, 10, 'Historia szyfrowania - Uzytkownik: ' . $username, 0, 1, 'C');
$pdf->Ln(5);

$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(10, 8, 'ID', 1);
$pdf->Cell(40, 8, 'Tekst', 1);
$pdf->Cell(30, 8, 'Klucz', 1);
$pdf->Cell(60, 8, 'Zaszyfrowany', 1);
$pdf->Cell(40, 8, 'Czas', 1);
$pdf->Ln();

$pdf->SetFont('Arial', '', 9);
while ($row = $result->fetch_assoc()) {
    $pdf->Cell(10, 8, $row['id'], 1);
    $pdf->Cell(40, 8, substr($row['input_text'], 0, 20), 1);
    $pdf->Cell(30, 8, $row['key_used'], 1);
    $pdf->Cell(60, 8, substr($row['encrypted_result'], 0, 30), 1);
    $pdf->Cell(40, 8, $row['timestamp'], 1);
    $pdf->Ln();
}

$pdf->Output('D', 'historia_szyfrowania.pdf');
exit();