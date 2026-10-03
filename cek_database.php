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

    echo "<h2>✅ Koneksi Database Berhasil</h2>";

    echo "<p><b>Database:</b> ";
    echo htmlspecialchars($pdo->query("SELECT DATABASE()")->fetchColumn());
    echo "</p>";

    $server = $pdo->query("SELECT @@hostname")->fetchColumn();
    echo "<p><b>Hostname:</b> ";
    echo htmlspecialchars($server);
    echo "</p>";

    $port = $pdo->query("SELECT @@port")->fetchColumn();
    echo "<p><b>Port MySQL:</b> ";
    echo htmlspecialchars($port);
    echo "</p>";

    $version = $pdo->query("SELECT VERSION()")->fetchColumn();
    echo "<p><b>Versi MySQL/MariaDB:</b> ";
    echo htmlspecialchars($version);
    echo "</p>";

    echo "<h3>Daftar Tabel:</h3>";

    $tables = $pdo->query("SHOW TABLES")->fetchAll(PDO::FETCH_COLUMN);

    if (empty($tables)) {

        echo "<p style='color:red;'>❌ Tidak ada tabel pada database ini.</p>";

    } else {

        echo "<ul>";

        foreach ($tables as $table) {
            echo "<li>" . htmlspecialchars($table) . "</li>";
        }

        echo "</ul>";
    }

} catch (PDOException $e) {

    echo "<h2>❌ Gagal</h2>";

    echo "<pre>";
    echo htmlspecialchars($e->getMessage());
    echo "</pre>";
}