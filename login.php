<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/config/database.php';


// Jika sudah login
if (
    isset($_SESSION['login']) &&
    $_SESSION['login'] === true
) {

    header('Location: dashboard.php');
    exit;
}


$pesan = '';

$email = '';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $email = trim($_POST['email'] ?? '');

    $password = $_POST['password'] ?? '';


    if ($email === '' || $password === '') {

        $pesan = 'Email dan password wajib diisi.';

    } else {

        try {

            $stmt = $pdo->prepare("
                SELECT
                    id,
                    nama,
                    email,
                    no_hp,
                    alamat,
                    password
                FROM users
                WHERE email = ?
                LIMIT 1
            ");

            $stmt->execute([
                $email
            ]);

            $user = $stmt->fetch();


            if (!$user) {

                $pesan = 'Email atau password salah.';

            } elseif (
                !password_verify(
                    $password,
                    $user['password']
                )
            ) {

                $pesan = 'Email atau password salah.';

            } else {

                // Regenerasi session untuk keamanan
                session_regenerate_id(true);


                // Simpan session
                $_SESSION['login'] = true;

                $_SESSION['user_id'] =
                    $user['id'];

                $_SESSION['nama'] =
                    $user['nama'];

                $_SESSION['email'] =
                    $user['email'];

                $_SESSION['no_hp'] =
                    $user['no_hp'];


                // Masuk dashboard
                header('Location: dashboard.php');
                exit;
            }

        } catch (PDOException $e) {

            $pesan =
                'Terjadi kesalahan database.';
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

    <title>
        Login - API WhatsApp
    </title>

    <style>

        * {
            box-sizing: border-box;
        }

        body {

            margin: 0;

            min-height: 100vh;

            display: flex;

            align-items: center;

            justify-content: center;

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

            max-width: 430px;

            background: white;

            padding: 35px;

            border-radius: 20px;

            box-shadow:
                0 15px 40px
                rgba(0,0,0,.2);
        }

        .logo {

            text-align: center;

            font-size: 55px;
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

            padding: 13px;

            border-radius: 10px;

            background: #f8d7da;

            color: #842029;

            margin-bottom: 20px;
        }

        label {

            display: block;

            margin-bottom: 7px;

            font-weight: bold;
        }

        input {

            width: 100%;

            padding: 13px;

            margin-bottom: 18px;

            border:
                1px solid #ddd;

            border-radius: 10px;

            font-size: 15px;

            outline: none;
        }

        input:focus {

            border-color: #25D366;
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

        .register {

            text-align: center;

            margin-top: 20px;

            color: #777;
        }

        .register a {

            color: #128C7E;

            text-decoration: none;

            font-weight: bold;
        }

    </style>

</head>

<body>


<div class="container">


    <div class="logo">
        📱
    </div>


    <h1>
        Login
    </h1>


    <div class="subtitle">
        Masuk ke Dashboard API WhatsApp
    </div>


    <?php if ($pesan !== ''): ?>

        <div class="alert">

            <?= htmlspecialchars($pesan) ?>

        </div>

    <?php endif; ?>


    <form method="POST">


        <label>
            Email
        </label>

        <input
            type="email"
            name="email"
            placeholder="Masukkan email"
            value="<?= htmlspecialchars($email) ?>"
            required
        >


        <label>
            Password
        </label>

        <input
            type="password"
            name="password"
            placeholder="Masukkan password"
            required
        >


        <button type="submit">
            Login
        </button>


    </form>


    <div class="register">

        Belum punya akun?

        <a href="register.php">
            Daftar sekarang
        </a>

    </div>


</div>

</body>

</html>