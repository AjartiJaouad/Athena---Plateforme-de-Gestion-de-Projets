<?php
require('../config/database.php');

$message = '';
if (isset($_POST['register'])) {
    $username = trim($_POST['username']);
    $email    = trim($_POST['email']);
    $password = $_POST['password'];

    $stmt = $con->prepare("SELECT * FROM user WHERE email=?");
    $stmt->execute([$email]);



    if ($stmt->rowCount() > 0) {
        $message = "Email déjà utilisé";
    } else {

        $hash = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $con->prepare("INSERT INTO user (username,email,password) VALUES (?,?,?)");
        $stmt->execute([$username, $email, $hash]);
        $message = "Inscription réussie ! <a href='login.php'>Connectez-vous</a>";
    }
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 flex items-center justify-center min-h-screen">

    <div class="bg-[#0C172C] w-full max-w-md p-8 rounded-lg shadow-lg">
        <h1 class="text-3xl font-semibold text-purple-400 text-center mb-8">Créer un compte</h1>

        <form method="POST" action="register.php" class="space-y-6">
            <?php if ($message): ?>
                <p class="text-center text-white mb-4"><?= $message ?></p>
            <?php endif; ?>

            <div>
                <label class="block text-white text-sm mb-2">Nom complet</label>
                <input type="text" name="username" required
                    class="w-full px-3 py-2 bg-transparent text-white border-b border-slate-500 focus:border-purple-400 outline-none"
                    placeholder="Entrez votre nom">
            </div>

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

            <div class="flex items-center">
                <input id="terms" name="terms" type="checkbox" class="h-4 w-4 rounded" required>
                <label for="terms" class="text-white text-sm ml-2">
                    J'accepte les <a href="#" class="text-purple-400 hover:underline">Conditions d'utilisation</a>
                </label>
            </div>

            <div>
                <button type="submit" name="register"
                    class="w-full py-3 px-6 text-white font-medium rounded bg-purple-600 hover:bg-purple-500 transition">
                    S'inscrire
                </button>
            </div>

            <p class="text-center text-white text-sm">
                Déjà un compte ? <a href="login.php" class="text-purple-400 hover:underline">Connectez-vous</a>
            </p>
        </form>

    </div>

</body>

</html>