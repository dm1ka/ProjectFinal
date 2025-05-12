<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

include("db.php");

function vigenere_encrypt($text, $key) {
    $text = strtoupper($text);
    $key = strtoupper($key);
    $output = '';
    $keyIndex = 0;

    for ($i = 0; $i < strlen($text); $i++) {
        $char = $text[$i];
        if (ctype_alpha($char)) {
            $shift = ord($key[$keyIndex % strlen($key)]) - 65;
            $output .= chr(((ord($char) - 65 + $shift) % 26) + 65);
            $keyIndex++;
        } else {
            $output .= $char;
        }
    }
    return $output;
}

function vigenere_decrypt($text, $key) {
    $text = strtoupper($text);
    $key = strtoupper($key);
    $output = '';
    $keyIndex = 0;

    for ($i = 0; $i < strlen($text); $i++) {
        $char = $text[$i];
        if (ctype_alpha($char)) {
            $shift = ord($key[$keyIndex % strlen($key)]) - 65;
            $output .= chr(((ord($char) - 65 - $shift + 26) % 26) + 65);
            $keyIndex++;
        } else {
            $output .= $char;
        }
    }
    return $output;
}

$text = '';
if (!empty($_POST['text'])) {
    $text = $_POST['text'];
} elseif (isset($_FILES['textfile']) && $_FILES['textfile']['error'] === UPLOAD_ERR_OK) {
    $text = file_get_contents($_FILES['textfile']['tmp_name']);
}

$key = $_POST['key'] ?? '';
$action = $_POST['action'] ?? '';
$username = $_SESSION['username'];

if ($text && $key && $action) {
    if ($action === 'encrypt') {
        $result = vigenere_encrypt($text, $key);
        $stmt = $conn->prepare("INSERT INTO encrypted_data (username, input_text, encrypted_result, key_used) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $username, $text, $result, $key);
        $stmt->execute();
    } elseif ($action === 'decrypt') {
        $result = vigenere_decrypt($text, $key);
        $stmt = $conn->prepare("INSERT INTO decrypted_data (username, input_text, decrypted_result, key_used) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $username, $text, $result, $key);
        $stmt->execute();
    } else {
        $result = "Nieznana akcja.";
    }
} else {
    $result = "Brakuje danych.";
}
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Wynik operacji</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .result-container {
            max-width: 700px;
            margin: 80px auto;
            background: #e3f2fd;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 0 15px rgba(0,0,0,0.2);
            text-align: center;
            font-family: 'Courier New', Courier, monospace;
        }

        .result-container h2 {
            color: #00796b;
            margin-bottom: 20px;
        }

        .result-box pre {
            font-size: 18px;
            color: #333;
            white-space: pre-wrap;
            word-wrap: break-word;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 10px;
            border: 1px solid #ccc;
        }

        .result-container .buttons {
            margin-top: 20px;
        }

        .result-container .buttons a button {
            font-size: 16px;
        }
    </style>
</head>
<body>
    <div class="result-container">
        <h2>Wynik operacji</h2>
        <div class="result-box">
            <pre><?= htmlspecialchars($result) ?></pre>
        </div>
        <div class="buttons">
            <a href="index.php">
                <button>Powrót</button>
            </a>
        </div>
    </div>
</body>
</html>