<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}
?><!DOCTYPE html><html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Szyfrowanie i Deszyfrowanie</title>
    <link rel="stylesheet" href="style.css">
    <script src="script.js" defer></script>
</head>
<body>
    <header class="main-header">
        <h1>Szyfrowanie i deszyfrowanie tekstu</h1>
        <form method="post" action="logout.php" class="logout-form">
            <button type="submit" class="logout-button">Wyloguj się</button>
        </form>
    </header><main>
    <section class="form-section">
        <form action="process.php" method="post" enctype="multipart/form-data">
            <label for="text">Tekst do przetworzenia:</label>
            <textarea id="text" name="text" rows="5"></textarea>

            <label for="file">Lub wgraj plik .txt:</label>
            <input type="file" id="file" name="textfile" accept=".txt">

            <label for="key">Klucz:</label>
            <input type="text" id="key" name="key" required>
            <div id="keyStrength"></div>

            <div class="buttons">
                <button type="submit" name="action" value="encrypt">Zaszyfruj</button>
                <button type="submit" name="action" value="decrypt">Odszyfruj</button>
            </div>
        </form>
    </section>

    <section class="history">
        <h2>Historia szyfrowania</h2>
        <iframe src="history_encrypt.php"></iframe>
        <div class="buttons">
            <form action="clear_encrypt_history.php" method="post">
                <button type="submit">Usuń historię</button>
            </form>
            <form action="export_encrypt.php" method="post">
                <button type="submit">Eksportuj PDF</button>
            </form>
        </div>
    </section>

    <section class="history">
        <h2>Historia deszyfrowania</h2>
        <iframe src="history_decrypt.php"></iframe>
        <div class="buttons">
            <form action="clear_decrypt_history.php" method="post">
                <button type="submit">Usuń historię</button>
            </form>
            <form action="export_decrypt.php" method="post">
                <button type="submit">Eksportuj PDF</button>
            </form>
        </div>
    </section>
</main>

</body>
</html>