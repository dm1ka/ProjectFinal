<?php
session_start();
require_once 'db.php';
if (!isset($_SESSION['username'])) {
    exit("Brak dostępu.");
}
$username = $_SESSION['username'];

$result = $conn->prepare("SELECT * FROM encrypted_data WHERE username = ? ORDER BY timestamp DESC");
$result->bind_param("s", $username);
$result->execute();
$data = $result->get_result();
?><!DOCTYPE html><html lang="pl">
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: Arial; font-size: 14px; margin: 0; }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 8px; border: 1px solid #ccc; text-align: center; }
        th { background-color: #0097a7; color: white; }
    </style>
</head>
<body>
    <table>
        <tr>
            <th>ID</th>
            <th>Tekst</th>
            <th>Klucz</th>
            <th>Wynik</th>
            <th>Czas</th>
        </tr>
        <?php while ($row = $data->fetch_assoc()): ?>
        <tr>
            <td><?= $row['id'] ?></td>
            <td><?= htmlspecialchars($row['input_text']) ?></td>
            <td><?= htmlspecialchars($row['key_used']) ?></td>
            <td><?= htmlspecialchars($row['encrypted_result']) ?></td>
            <td><?= $row['timestamp'] ?></td>
        </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>