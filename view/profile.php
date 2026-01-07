<?php
require_once '../config/database.php';
require_once '../entites/User.php';
require_once '../services/AuthService.php';

session_start();
AuthService::check();
$user = AuthService::user($con);

$message = '';

if (isset($_POST['update'])) {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    // Mettre à jour via objet User
    $user->setUsername($username);
    $user->setEmail($email);
    if (!empty($password)) {
        $user->hashAndSetPassword($password);
    }

    // Update en DB
    $user->update($con);

    $message = "Profil mis à jour !";
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Profil</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 flex items-center justify-center min-h-screen">

    <div class="bg-[#0C172C] w-full max-w-md p-8 rounded-lg shadow-lg">

        <h1 class="text-3xl font-semibold text-purple-400 text-center mb-6">
            Mon Profil
        </h1>

        <?php if ($message): ?>
            <p class="text-center text-white mb-4"><?= htmlspecialchars($message) ?></p>
        <?php endif; ?>

        <form method="POST" class="space-y-6">

            <div>
                <label class="block text-white text-sm mb-2">Nom d'utilisateur</label>
                <input type="text" name="username" value="<?= htmlspecialchars($user->getUsername()) ?>"
                    class="w-full px-3 py-2 bg-transparent text-white border-b border-slate-500 focus:border-purple-400 outline-none">
            </div>

            <div>
                <label class="block text-white text-sm mb-2">Email</label>
                <input type="email" name="email" value="<?= htmlspecialchars($user->getEmail()) ?>"
                    class="w-full px-3 py-2 bg-transparent text-white border-b border-slate-500 focus:border-purple-400 outline-none">
            </div>

            <div>
                <label class="block text-white text-sm mb-2">Nouveau mot de passe</label>
                <input type="password" name="password"
                    placeholder="Laisser vide pour ne pas changer"
                    class="w-full px-3 py-2 bg-transparent text-white border-b border-slate-500 focus:border-purple-400 outline-none">
            </div>

            <button type="submit" name="update"
                class="w-full py-3 px-6 text-white font-medium rounded bg-purple-600 hover:bg-purple-500 transition">
                Mettre à jour
            </button>

        </form>

        <div class="mt-6 text-center text-white text-sm">
            <p>Rôle : <strong><?= htmlspecialchars($user->getRole()->value) ?></strong></p>
        </div>

        <div class="mt-6 flex justify-between text-sm">
            <a href="dashboard.php" class="text-purple-400 hover:underline">Dashboard</a>
            <a href="logout.php" class="text-red-400 hover:underline">Déconnexion</a>
        </div>

    </div>

</body>

</html>