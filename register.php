<?php
session_start();
if (isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}
?><!DOCTYPE html><html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Rejestracja</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .auth-box {
            max-width: 400px;
            margin: 100px auto;
            background: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 0 15px rgba(0,0,0,0.2);
            text-align: center;
        }
        .auth-box h2 {
            margin-bottom: 20px;
            color: #00796b;
        }
        .auth-box input {
            width: 100%;
            padding: 12px;
            margin-bottom: 15px;
            border-radius: 8px;
            border: 1px solid #ccc;
            font-size: 16px;
        }
        .auth-box button {
            width: 100%;
            padding: 12px;
            background: #0097a7;
            border: none;
            color: white;
            border-radius: 8px;
            font-size: 16px;
        }
        .auth-box button:hover {
            background: #00796b;
        }
        .auth-box p {
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="auth-box">
        <h2>Rejestracja</h2>
        <form action="register_process.php" method="post">
            <input type="text" name="username" placeholder="Nazwa użytkownika" required>
            <input type="password" name="password" placeholder="Hasło" required>
            <button type="submit">Zarejestruj się</button>
        </form>
        <p>Masz już konto? <a href="login.php">Zaloguj się</a></p>
    </div>
</body>
</html>