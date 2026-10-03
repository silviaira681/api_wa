<?php

require_once __DIR__ . '/auth_check.php';

$nama = $_SESSION['nama'] ?? 'Pengguna';
$email = $_SESSION['email'] ?? '';
$no_hp = $_SESSION['no_hp'] ?? '';

?>

<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        Dashboard - API WhatsApp
    </title>

    <style>

        * {
            box-sizing: border-box;
        }

        body {

            margin: 0;

            font-family: Arial, sans-serif;

            background: #f4f7f6;

            color: #222;
        }

        .navbar {

            height: 70px;

            background: #128C7E;

            color: white;

            display: flex;

            align-items: center;

            justify-content: space-between;

            padding: 0 35px;
        }

        .brand {

            font-size: 21px;

            font-weight: bold;
        }

        .logout {

            color: white;

            text-decoration: none;

            background: #dc3545;

            padding: 10px 18px;

            border-radius: 8px;

            font-weight: bold;
        }

        .logout:hover {

            background: #bb2d3b;
        }

        .content {

            max-width: 1100px;

            margin: 40px auto;

            padding: 0 20px;
        }

        .welcome {

            background: white;

            padding: 30px;

            border-radius: 16px;

            margin-bottom: 25px;

            box-shadow:
                0 5px 20px
                rgba(0,0,0,.06);
        }

        .welcome h1 {

            margin-top: 0;

            color: #128C7E;
        }

        .welcome p {

            color: #666;

        }

        .cards {

            display: grid;

            grid-template-columns:
                repeat(
                    auto-fit,
                    minmax(220px, 1fr)
                );

            gap: 20px;
        }

        .card {

            background: white;

            padding: 25px;

            border-radius: 16px;

            box-shadow:
                0 5px 20px
                rgba(0,0,0,.06);
        }

        .icon {

            font-size: 38px;

            margin-bottom: 10px;
        }

        .card h3 {

            margin: 0 0 10px;

        }

        .card p {

            color: #777;

            line-height: 1.5;
        }

        .profile {

            margin-top: 25px;

            background: white;

            padding: 25px;

            border-radius: 16px;

            box-shadow:
                0 5px 20px
                rgba(0,0,0,.06);
        }

        .profile h2 {

            margin-top: 0;

            color: #128C7E;
        }

        .data {

            padding: 12px 0;

            border-bottom:
                1px solid #eee;
        }

        .data:last-child {

            border-bottom: none;
        }

        .label {

            display: block;

            color: #888;

            font-size: 13px;

            margin-bottom: 4px;
        }

        .value {

            font-weight: bold;
        }

        @media (max-width: 600px) {

            .navbar {

                padding: 0 15px;
            }

            .brand {

                font-size: 17px;
            }

            .content {

                margin-top: 25px;
            }

        }

    </style>

</head>

<body>


<nav class="navbar">

    <div class="brand">
        📱 API WhatsApp
    </div>

    <a
        href="logout.php"
        class="logout"
        onclick="return confirm('Yakin ingin logout?')"
    >
        Logout
    </a>

</nav>


<main class="content">


    <section class="welcome">

        <h1>
            Selamat Datang, <?= htmlspecialchars($nama) ?>! 👋
        </h1>

        <p>
            Kamu berhasil masuk ke Dashboard API WhatsApp.
        </p>

    </section>


    <section class="cards">


        <div class="card">

            <div class="icon">
                👤
            </div>

            <h3>
                Profil
            </h3>

            <p>
                Melihat informasi akun yang sedang login.
            </p>

        </div>


        <div class="card">

            <div class="icon">
                📱
            </div>

            <h3>
                WhatsApp
            </h3>

            <p>
                Sistem terhubung dengan layanan WhatsApp
                melalui Fonnte.
            </p>

        </div>


        <div class="card">

            <div class="icon">
                🔔
            </div>

            <h3>
                Notifikasi
            </h3>

            <p>
                Notifikasi WhatsApp digunakan untuk
                memberikan informasi kepada pengguna.
            </p>

        </div>


        <div class="card">

            <div class="icon">
                🔐
            </div>

            <h3>
                Keamanan
            </h3>

            <p>
                Akun dilindungi menggunakan session
                dan password yang sudah di-hash.
            </p>

        </div>


    </section>


    <section class="profile">

        <h2>
            Informasi Akun
        </h2>


        <div class="data">

            <span class="label">
                Nama
            </span>

            <span class="value">
                <?= htmlspecialchars($nama) ?>
            </span>

        </div>


        <div class="data">

            <span class="label">
                Email
            </span>

            <span class="value">
                <?= htmlspecialchars($email) ?>
            </span>

        </div>


        <div class="data">

            <span class="label">
                Nomor WhatsApp
            </span>

            <span class="value">
                <?= htmlspecialchars($no_hp) ?>
            </span>

        </div>

    </section>


</main>

</body>

</html>