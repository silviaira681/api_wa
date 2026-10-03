<?php

// =====================================================
// REGISTER
// =====================================================

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/functions/fonnte.php';


// =====================================================
// VARIABEL
// =====================================================

$pesan = '';
$tipe = '';

$nama = '';
$email = '';
$no_hp = '';
$alamat = '';


// =====================================================
// PROSES REGISTER
// =====================================================

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $nama = trim($_POST['nama'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $no_hp = trim($_POST['no_hp'] ?? '');
    $alamat = trim($_POST['alamat'] ?? '');

    $password = $_POST['password'] ?? '';
    $konfirmasi_password =
        $_POST['konfirmasi_password'] ?? '';


    // =================================================
    // VALIDASI
    // =================================================

    if (
        $nama === '' ||
        $email === '' ||
        $no_hp === '' ||
        $alamat === '' ||
        $password === '' ||
        $konfirmasi_password === ''
    ) {

        $pesan = 'Semua data wajib diisi.';
        $tipe = 'error';

    }

    elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

        $pesan = 'Format email tidak valid.';
        $tipe = 'error';

    }

    elseif (!preg_match('/^[0-9+\-\s]{10,20}$/', $no_hp)) {

        $pesan = 'Nomor WhatsApp tidak valid.';
        $tipe = 'error';

    }

    elseif (strlen($password) < 6) {

        $pesan = 'Password minimal 6 karakter.';
        $tipe = 'error';

    }

    elseif ($password !== $konfirmasi_password) {

        $pesan = 'Konfirmasi password tidak sama.';
        $tipe = 'error';

    }

    else {

        try {

            // =========================================
            // CEK EMAIL
            // =========================================

            $cekEmail = $pdo->prepare("
                SELECT id
                FROM users
                WHERE email = ?
                LIMIT 1
            ");

            $cekEmail->execute([$email]);

            if ($cekEmail->fetch()) {

                $pesan =
                    'Email sudah terdaftar. Silakan gunakan email lain.';

                $tipe = 'error';

            } else {

                // =====================================
                // CEK NOMOR HP
                // =====================================

                $cekNoHp = $pdo->prepare("
                    SELECT id
                    FROM users
                    WHERE no_hp = ?
                    LIMIT 1
                ");

                $cekNoHp->execute([$no_hp]);

                if ($cekNoHp->fetch()) {

                    $pesan =
                        'Nomor WhatsApp sudah terdaftar. '
                        . 'Silakan gunakan nomor lain.';

                    $tipe = 'error';

                } else {

                    // =================================
                    // HASH PASSWORD
                    // =================================

                    $passwordHash = password_hash(
                        $password,
                        PASSWORD_DEFAULT
                    );


                    // =================================
                    // SIMPAN USER
                    // =================================

                    $sql = "
                        INSERT INTO users
                        (
                            nama,
                            email,
                            no_hp,
                            alamat,
                            password,
                            created_at
                        )
                        VALUES
                        (
                            :nama,
                            :email,
                            :no_hp,
                            :alamat,
                            :password,
                            NOW()
                        )
                    ";

                    $stmt = $pdo->prepare($sql);

                    $stmt->execute([
                        ':nama' => $nama,
                        ':email' => $email,
                        ':no_hp' => $no_hp,
                        ':alamat' => $alamat,
                        ':password' => $passwordHash
                    ]);


                    // =================================
                    // AMBIL ID USER
                    // =================================

                    $userId = $pdo->lastInsertId();


                    // =================================
                    // KIRIM WHATSAPP
                    // =================================

                    $pesanWA =
                        "Halo {$nama},\n\n" .
                        "Registrasi akun kamu berhasil.\n\n" .
                        "Nama: {$nama}\n" .
                        "Email: {$email}\n\n" .
                        "Terima kasih telah mendaftar.";

                    $hasilWA = kirimWhatsApp(
                        $no_hp,
                        $pesanWA
                    );


                    // =================================
                    // LOGIN OTOMATIS
                    // =================================

                    $_SESSION['login'] = true;
                    $_SESSION['user_id'] = $userId;
                    $_SESSION['nama'] = $nama;
                    $_SESSION['email'] = $email;
                    $_SESSION['no_hp'] = $no_hp;


                    // =================================
                    // REDIRECT DASHBOARD
                    // =================================

                    header('Location: dashboard.php');
                    exit;
                }
            }

        } catch (PDOException $e) {

            if ($e->getCode() === '23000') {

                $pesan =
                    'Email atau nomor WhatsApp sudah terdaftar.';

            } else {

                $pesan =
                    'Terjadi kesalahan database.';

            }

            $tipe = 'error';
        }
    }
}

?>

<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Register - API WhatsApp</title>

    <style>

        * {
            box-sizing: border-box;
        }

        body {

            margin: 0;

            min-height: 100vh;

            display: flex;

            justify-content: center;

            align-items: center;

            padding: 20px;

            font-family: Arial, sans-serif;

            background:
                linear-gradient(
                    135deg,
                    #25D366,
                    #128C7E
                );
        }

        .container {

            width: 100%;

            max-width: 500px;

            background: white;

            padding: 35px;

            border-radius: 20px;

            box-shadow:
                0 15px 40px
                rgba(0,0,0,.2);
        }

        .logo {

            text-align: center;

            font-size: 50px;
        }

        h1 {

            text-align: center;

            margin: 5px 0;

        }

        .subtitle {

            text-align: center;

            color: #777;

            margin-bottom: 25px;
        }

        .alert {

            padding: 14px;

            border-radius: 10px;

            margin-bottom: 20px;

        }

        .error {

            background: #f8d7da;

            color: #842029;
        }

        label {

            display: block;

            margin-bottom: 7px;

            font-weight: bold;
        }

        input,
        textarea {

            width: 100%;

            padding: 13px;

            border: 1px solid #ddd;

            border-radius: 10px;

            margin-bottom: 17px;

            font-size: 15px;

            outline: none;
        }

        input:focus,
        textarea:focus {

            border-color: #25D366;

        }

        textarea {

            min-height: 90px;

            resize: vertical;
        }

        button {

            width: 100%;

            padding: 14px;

            border: none;

            border-radius: 10px;

            background: #25D366;

            color: white;

            font-size: 16px;

            font-weight: bold;

            cursor: pointer;
        }

        button:hover {

            background: #1ebe5d;

        }

        .login {

            text-align: center;

            margin-top: 20px;

            color: #777;
        }

        .login a {

            color: #128C7E;

            font-weight: bold;

            text-decoration: none;
        }

    </style>

</head>

<body>

<div class="container">

    <div class="logo">
        📱
    </div>

    <h1>
        Buat Akun
    </h1>

    <div class="subtitle">
        Daftar akun baru untuk menggunakan sistem
    </div>


    <?php if ($pesan !== ''): ?>

        <div class="alert <?= htmlspecialchars($tipe) ?>">

            <?= htmlspecialchars($pesan) ?>

        </div>

    <?php endif; ?>


    <form method="POST">


        <label>
            Nama Lengkap
        </label>

        <input
            type="text"
            name="nama"
            placeholder="Masukkan nama lengkap"
            value="<?= htmlspecialchars($nama) ?>"
            required
        >


        <label>
            Email
        </label>

        <input
            type="email"
            name="email"
            placeholder="contoh@gmail.com"
            value="<?= htmlspecialchars($email) ?>"
            required
        >


        <label>
            Nomor WhatsApp
        </label>

        <input
            type="text"
            name="no_hp"
            placeholder="08xxxxxxxxxx"
            value="<?= htmlspecialchars($no_hp) ?>"
            required
        >


        <label>
            Alamat
        </label>

        <textarea
            name="alamat"
            placeholder="Masukkan alamat"
            required
        ><?= htmlspecialchars($alamat) ?></textarea>


        <label>
            Password
        </label>

        <input
            type="password"
            name="password"
            placeholder="Minimal 6 karakter"
            required
        >


        <label>
            Konfirmasi Password
        </label>

        <input
            type="password"
            name="konfirmasi_password"
            placeholder="Ulangi password"
            required
        >


        <button type="submit">
            Daftar Sekarang
        </button>

    </form>


    <div class="login">

        Sudah punya akun?

        <a href="login.php">
            Login di sini
        </a>

    </div>

</div>

</body>

</html>