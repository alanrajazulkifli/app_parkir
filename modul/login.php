<?php
session_start();
require_once '../lib/koneksi.php';

if (isset($_SESSION['user'])) {
    header('Location: index.php');
    exit;
}

$error = '';

if (isset($_POST['login'])) {
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');

    $user = null;

    if ($username !== '' && $password !== '') {
        $defaultUsers = [
            'min' => ['password' => '123', 'role' => 'admin'],
            'al' => ['password' => '123', 'role' => 'petugas'],
        ];

        if (isset($defaultUsers[$username]) && $defaultUsers[$username]['password'] === $password) {
            $user = [
                'username' => $username,
                'role' => $defaultUsers[$username]['role'],
            ];
        } elseif ($conn && !$conn->connect_error) {
            $stmt = $conn->prepare("SELECT username, role FROM users WHERE username = ? AND password = ? LIMIT 1");
            if ($stmt) {
                $stmt->bind_param('ss', $username, $password);
                $stmt->execute();
                $result = $stmt->get_result();
                if ($result && $result->num_rows > 0) {
                    $user = $result->fetch_assoc();
                }
                $stmt->close();
            }
        }
    }

    if ($user) {
        $_SESSION['user'] = $user['username'];
        $_SESSION['role'] = $user['role'];
        header('Location: index.php');
        exit;
    }

    $error = 'Username atau password salah.';
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login System Parkir</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-100 min-h-screen flex items-center justify-center p-4">

    <div class="bg-white p-8 rounded-xl shadow-md w-full max-w-md border border-slate-200">
        <div class="text-center mb-6">
            <h1 class="text-2xl font-bold text-slate-800">Aplikasi Parkir</h1>
            <p class="text-slate-500 text-sm">Pilih akses cepat atau masukkan manual</p>
        </div>

        <div class="mb-5 grid grid-cols-2 gap-3">
            <button type="button" onclick="quickLogin('min', '123')"
                    class="bg-indigo-50 hover:bg-indigo-100 text-indigo-700 font-medium py-2 px-3 rounded-lg border border-indigo-200 transition text-sm flex items-center justify-center gap-1.5 shadow-sm">
                <span>👑</span> Login Admin
            </button>
            <button type="button" onclick="quickLogin('al', '123')"
                    class="bg-emerald-50 hover:bg-emerald-100 text-emerald-700 font-medium py-2 px-3 rounded-lg border border-emerald-200 transition text-sm flex items-center justify-center gap-1.5 shadow-sm">
                <span>🎫</span> Login Petugas
            </button>
        </div>

        <div class="relative flex py-1 items-center mb-4">
            <div class="flex-grow border-t border-slate-200"></div>
            <span class="flex-shrink mx-3 text-xs text-slate-400">atau isi form</span>
            <div class="flex-grow border-t border-slate-200"></div>
        </div>

        <?php if ($error): ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4 text-sm">
                <?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?>
            </div>
        <?php endif; ?>

        <form action="" method="POST" class="space-y-4">
            <div>
                <label for="username" class="block text-sm font-medium text-slate-700 mb-1">Username</label>
                <input type="text" name="username" id="username" required
                       class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none transition">
            </div>

            <div>
                <label for="password" class="block text-sm font-medium text-slate-700 mb-1">Password</label>
                <input type="password" name="password" id="password" required
                       class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none transition">
            </div>

            <button type="submit" name="login"
                    class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2.5 rounded-lg transition duration-200 shadow">
                Masuk
            </button>
        </form>
    </div>

    <script>
        function quickLogin(username, password) {
            document.getElementById('username').value = username;
            document.getElementById('password').value = password;
            document.getElementById('password').focus();
        }
    </script>

</body>
</html>