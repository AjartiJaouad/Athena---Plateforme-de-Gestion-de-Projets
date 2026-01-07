<?php
require_once __DIR__ . '/../entites/User.php';
require_once __DIR__ . '/../config/database.php';
require_once '../services/AuthService.php';

session_start();
AuthService::check();
$user = AuthService::user($con);
?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Athena</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-[#0C172C] min-h-screen flex flex-col">

    <!-- HEADER -->
    <header class="bg-[#0C172C] p-6 shadow-md flex justify-between items-center">
        <h1 class="text-2xl font-bold text-purple-400">Athena</h1>
        <a href="logout.php" class="text-red-400 hover:underline font-semibold">Déconnexion</a>
    </header>


    <!-- MAIN CONTENT -->
    <main class="flex-1 p-8">
        <div class="max-w-6xl mx-auto">

            <h2 class="text-3xl font-semibold text-purple-400 text-center mb-4">
                Bienvenue, <strong><?= htmlspecialchars($user->getUsername()) ?></strong> !
            </h2>
            <p class="text-center text-gray-300 mb-10">
                Email : <strong><?= htmlspecialchars($user->getEmail()) ?></strong><br>
                Rôle : <strong><?= htmlspecialchars($user->getRole()->value) ?></strong>
            </p>

            
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">

                <!-- Mon Profil -->
                <div class="bg-[#1A2238] p-6 rounded-lg shadow hover:shadow-lg transition">
                    <h3 class="text-white font-bold mb-2">Mon profil</h3>
                    <p class="text-gray-300 mb-4">Consultez et modifiez vos informations personnelles.</p>
                    <a href="profile.php" class="text-purple-400 hover:underline font-semibold">Modifier mon profil</a>
                </div>

                <!-- Projets -->
                <div class="bg-[#1A2238] p-6 rounded-lg shadow hover:shadow-lg transition">
                    <h3 class="text-white font-bold mb-2">Projets</h3>
                    <p class="text-gray-300 mb-4">Créer et gérer vos projets.</p>
                    <a href="projects.php" class="text-purple-400 hover:underline font-semibold">Voir mes projets</a>
                </div>

                <!-- Tâches -->
                <div class="bg-[#1A2238] p-6 rounded-lg shadow hover:shadow-lg transition">
                    <h3 class="text-white font-bold mb-2">Tâches</h3>
                    <p class="text-gray-300 mb-4">Suivez vos tâches et leur avancement.</p>
                    <a href="tasks.php" class="text-purple-400 hover:underline font-semibold">Voir mes tâches</a>
                </div>

                <!-- Administration (Admin seulement) -->
                <?php if ($user->getRole() === UserRole::ADMIN): ?>
                    <div class="bg-[#1A2238] p-6 rounded-lg shadow border border-purple-500/30 hover:shadow-lg transition">
                        <h3 class="text-white font-bold mb-2">Administration</h3>
                        <p class="text-gray-300 mb-4">Voir statistiques et gérer les utilisateurs.</p>
                        <a href="admin.php" class="text-purple-400 hover:underline font-semibold">Voir les statistiques</a>
                    </div>
                <?php endif; ?>

            </div>
        </div>
    </main>

    <!-- FOOTER -->
    <footer class="bg-[#0C172C] text-white text-center p-6 shadow-inner mt-auto">
        <p>© 2026 Athena. Tous droits réservés.</p>
    </footer>

</body>
</html>
