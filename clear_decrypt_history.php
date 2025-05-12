<?php
session_start();
require_once 'db.php';
if (!isset($_SESSION['username'])) {
    exit("Brak dostępu.");
}
$username = $_SESSION['username'];

$stmt = $conn->prepare("DELETE FROM decrypted_data WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();

header("Location: index.php");
exit();