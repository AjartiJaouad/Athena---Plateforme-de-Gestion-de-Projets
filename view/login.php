<?php
session_start();
require('../config/database.php');

$message = '';
if (isset($_POST['login'])) {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    $stmt = $con->prepare("SELECT * FROM user WHERE email=?");
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['user_id'];
        $_SESSION['username'] = $user['username'];
        header('Location: dashboard.php');
        exit;
    } else {
        $message = "Email ou mot de passe incorrect";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 flex items-center justify-center min-h-screen">

    <div class="bg-[#0C172C] w-full max-w-md p-8 rounded-lg shadow-lg">
        <h1 class="text-3xl font-semibold text-purple-400 text-center mb-8">Connexion</h1>

        <form method="POST" action="login.php" class="space-y-6">
            <?php if ($message): ?>
                <p class="text-center text-white mb-4"><?= $message ?></p>
            <?php endif; ?>

            <div>
                <label class="block text-white text-sm mb-2">Email</label>
                <input type="email" name="email" required
                    class="w-full px-3 py-2 bg-transparent text-white border-b border-slate-500 focus:border-purple-400 outline-none"
                    placeholder="Entrez votre email">
            </div>

            <div>
                <label class="block text-white text-sm mb-2">Mot de passe</label>
                <input type="password" name="password" required
                    class="w-full px-3 py-2 bg-transparent text-white border-b border-slate-500 focus:border-purple-400 outline-none"
                    placeholder="Entrez votre mot de passe">
            </div>

            <div>
                <button type="submit" name="login"
                    class="w-full py-3 px-6 text-white font-medium rounded bg-purple-600 hover:bg-purple-500 transition">
                    Se connecter
                </button>
            </div>

            <p class="text-center text-white text-sm">
                Pas de compte ? <a href="register.php" class="text-purple-400 hover:underline">Inscrivez-vous</a>
            </p>
        </form>
    </div>

</body>

</html>
