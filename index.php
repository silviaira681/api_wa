<?php

session_start();

$error = $_SESSION['error'] ?? '';
$success = $_SESSION['success'] ?? '';
$wa_status = $_SESSION['wa_status'] ?? '';
$wa_success = $_SESSION['wa_success'] ?? false;

$wa_error_detail = $_SESSION['wa_error_detail'] ?? '';
$wa_http_code = $_SESSION['wa_http_code'] ?? '';

unset(
    $_SESSION['error'],
    $_SESSION['success'],
    $_SESSION['wa_status'],
    $_SESSION['wa_success'],
    $_SESSION['wa_error_detail'],
    $_SESSION['wa_http_code']
);

?>

<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Registrasi - API WhatsApp</title>

    <style>

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: Arial, sans-serif;
            min-height: 100vh;
            background: #f0fdf4;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 25px;
        }

        .container {
            width: 100%;
            max-width: 1050px;
            background: white;
            border-radius: 24px;
            overflow: hidden;
            box-shadow: 0 15px 45px rgba(0,0,0,.12);
            display: grid;
            grid-template-columns: 42% 58%;
        }

        .left {
            background: linear-gradient(
                135deg,
                #047857,
                #10b981
            );
            color: white;
            padding: 50px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .logo {
            font-size: 42px;
            margin-bottom: 20px;
        }

        .left h1 {
            font-size: 34px;
            margin-bottom: 15px;
        }

        .left p {
            line-height: 1.7;
            color: #ecfdf5;
            margin-bottom: 30px;
        }

        .features {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .feature {
            background: rgba(255,255,255,.13);
            padding: 14px 18px;
            border-radius: 12px;
        }

        .right {
            padding: 45px;
        }

        .right h2 {
            color: #064e3b;
            font-size: 30px;
            margin-bottom: 8px;
        }

        .subtitle {
            color: #64748b;
            margin-bottom: 25px;
        }

        .alert {
            padding: 14px 16px;
            border-radius: 10px;
            margin-bottom: 18px;
            line-height: 1.5;
        }

        .error {
            background: #fef2f2;
            color: #b91c1c;
            border: 1px solid #fecaca;
        }

        .success {
            background: #f0fdf4;
            color: #166534;
            border: 1px solid #bbf7d0;
        }

        .warning {
            background: #fffbeb;
            color: #92400e;
            border: 1px solid #fde68a;
        }

        .form-group {
            margin-bottom: 17px;
        }

        label {
            display: block;
            font-weight: bold;
            color: #334155;
            margin-bottom: 7px;
        }

        input,
        textarea {
            width: 100%;
            border: 1px solid #cbd5e1;
            border-radius: 10px;
            padding: 13px 14px;
            font-size: 15px;
            outline: none;
            transition: .2s;
        }

        input:focus,
        textarea:focus {
            border-color: #10b981;
            box-shadow: 0 0 0 3px rgba(16,185,129,.12);
        }

        textarea {
            min-height: 90px;
            resize: vertical;
        }

        button {
            width: 100%;
            border: none;
            border-radius: 11px;
            padding: 14px;
            background: #059669;
            color: white;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: .2s;
        }

        button:hover {
            background: #047857;
        }

        .info {
            margin-top: 15px;
            font-size: 13px;
            color: #64748b;
            text-align: center;
            line-height: 1.5;
        }

        @media(max-width: 800px) {

            .container {
                grid-template-columns: 1fr;
            }

            .left {
                padding: 35px;
            }

            .right {
                padding: 35px;
            }

        }

    </style>

</head>

<body>

<div class="container">

    <div class="left">

        <div class="logo">📱</div>

        <h1>API WhatsApp</h1>

        <p>
            Sistem registrasi dengan notifikasi
            WhatsApp otomatis menggunakan
            Fonnte API.
        </p>

        <div class="features">

            <div class="feature">
                ✅ Registrasi pengguna
            </div>

            <div class="feature">
                🔐 Password aman
            </div>

            <div class="feature">
                💾 Database MySQL
            </div>

            <div class="feature">
                📲 Notifikasi WhatsApp
            </div>

        </div>

    </div>


    <div class="right">

        <h2>Buat Akun</h2>

        <p class="subtitle">
            Silakan isi data berikut untuk melakukan registrasi.
        </p>


        <?php if ($error): ?>

            <div class="alert error">
                ❌ <?= htmlspecialchars($error) ?>
            </div>

        <?php endif; ?>


        <?php if ($success): ?>

            <div class="alert success">
                ✅ <?= htmlspecialchars($success) ?>
            </div>

        <?php endif; ?>


        <?php if ($wa_status): ?>

            <div class="alert <?= $wa_success ? 'success' : 'warning' ?>">

                <?= $wa_success ? '📱' : '⚠️' ?>

                <?= htmlspecialchars($wa_status) ?>

                <?php if (!$wa_success && $wa_http_code): ?>

                    <br>
                    <small>
                        HTTP Code:
                        <?= htmlspecialchars($wa_http_code) ?>
                    </small>

                <?php endif; ?>

                <?php if (!$wa_success && $wa_error_detail): ?>

                    <br>
                    <small>
                        Response:
                        <?= htmlspecialchars($wa_error_detail) ?>
                    </small>

                <?php endif; ?>

            </div>

        <?php endif; ?>


        <form
            action="api/register.php"
            method="POST"
        >

            <div class="form-group">

                <label>Nama</label>

                <input
                    type="text"
                    name="nama"
                    placeholder="Masukkan nama lengkap"
                    required
                >

            </div>


            <div class="form-group">

                <label>Email</label>

                <input
                    type="email"
                    name="email"
                    placeholder="contoh@gmail.com"
                    required
                >

            </div>


            <div class="form-group">

                <label>Nomor WhatsApp</label>

                <input
                    type="text"
                    name="no_hp"
                    placeholder="081234567890"
                    required
                >

            </div>


            <div class="form-group">

                <label>Alamat</label>

                <textarea
                    name="alamat"
                    placeholder="Masukkan alamat"
                    required
                ></textarea>

            </div>


            <div class="form-group">

                <label>Password</label>

                <input
                    type="password"
                    name="password"
                    placeholder="Minimal 6 karakter"
                    minlength="6"
                    required
                >

            </div>


            <button type="submit">
                🚀 Register
            </button>

        </form>


        <div class="info">

            Setelah registrasi berhasil,
            sistem akan mencoba mengirim
            notifikasi WhatsApp otomatis.

        </div>

    </div>

</div>

</body>

</html>