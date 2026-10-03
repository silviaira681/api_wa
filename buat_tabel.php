<?php

$host = '127.0.0.1';
$db   = 'api_wa_fonnte';
$user = 'root';
$pass = '';

try {

    $pdo = new PDO(
        "mysql:host=$host;dbname=$db;charset=utf8mb4",
        $user,
        $pass,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]
    );

    echo "<h2>Database: api_wa_fonnte</h2>";

    // Buat tabel users
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS users (
            id INT AUTO_INCREMENT PRIMARY KEY,
            nama VARCHAR(100) NOT NULL,
            email VARCHAR(150) NOT NULL UNIQUE,
            no_hp VARCHAR(20) NOT NULL UNIQUE,
            alamat TEXT NOT NULL,
            password VARCHAR(255) NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )
    ");

    echo "<p style='color:green;'>✅ Tabel users berhasil dibuat/ sudah tersedia.</p>";

    // Buat tabel log_whatsapp
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS log_whatsapp (
            id INT AUTO_INCREMENT PRIMARY KEY,
            user_id INT NULL,
            no_tujuan VARCHAR(20) NOT NULL,
            pesan TEXT NOT NULL,
            status VARCHAR(30) NOT NULL,
            response TEXT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )
    ");

    echo "<p style='color:green;'>✅ Tabel log_whatsapp berhasil dibuat/ sudah tersedia.</p>";

    echo "<h3>Daftar tabel sekarang:</h3>";

    $tables = $pdo->query("SHOW TABLES")->fetchAll(PDO::FETCH_COLUMN);

    echo "<ul>";

    foreach ($tables as $table) {
        echo "<li>" . htmlspecialchars($table) . "</li>";
    }

    echo "</ul>";

    echo "<hr>";
    echo "<p><a href='index.php'>➡️ Kembali ke halaman registrasi</a></p>";

} catch (PDOException $e) {

    echo "<h2 style='color:red;'>❌ Gagal</h2>";

    echo "<pre>";
    echo htmlspecialchars($e->getMessage());
    echo "</pre>";
}