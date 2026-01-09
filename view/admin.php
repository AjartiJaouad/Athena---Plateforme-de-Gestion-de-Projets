<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once '../config/database.php';
require_once '../entites/User.php';
require_once '../services/AuthService.php';
require_once '../services/AdminService.php';

session_start();

AuthService::check();
$user = AuthService::user($con);

AuthService::requireRole(UserRole::ADMIN, $user);

$adminService = new AdminService($con);


if (isset($_POST['change_role'])) {
    $userId = (int) $_POST['user_id'];
    $role   = UserRole::from($_POST['role']);

    $adminService->setUserRole($userId, $role);

    header("Location: admin.php");
    exit;
}

$users = $adminService->getAllUsers();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Administration</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-[#0C172C] min-h-screen text-white">

<header class="p-6 shadow-md flex justify-between items-center">
    <h1 class="text-2xl font-bold text-purple-400">Administration</h1>
    <a href="dashboard.php" class="text-purple-400 hover:underline">
        Retour dashboard
    </a>
</header>

<main class="p-8 max-w-6xl mx-auto">

    <h2 class="text-xl mb-6">Gestion des utilisateurs</h2>

    <div class="overflow-x-auto">
        <table class="w-full border border-slate-700">
            <thead class="bg-[#1A2238]">
                <tr>
                    <th class="p-3 text-left">ID</th>
                    <th class="p-3 text-left">Nom</th>
                    <th class="p-3 text-left">Email</th>
                    <th class="p-3 text-left">Rôle actuel</th>
                    <th class="p-3 text-left">Action</th>
                </tr>
            </thead>

            <tbody>
                <?php foreach ($users as $u): ?>
                    <tr class="border-t border-slate-700 hover:bg-[#1A2238]">
                        <td class="p-3"><?= $u->getUserID() ?></td>
                        <td class="p-3"><?= htmlspecialchars($u->getUsername()) ?></td>
                        <td class="p-3"><?= htmlspecialchars($u->getEmail()) ?></td>
                        <td class="p-3"><?= $u->getRole()->value ?></td>

                        <td class="p-3">
                            <form method="POST" class="flex gap-2 items-center">
                                <input type="hidden" name="user_id" value="<?= $u->getUserID() ?>">

                                <select name="role"
                                    class="bg-[#0C172C] border border-slate-600 text-white rounded px-2 py-1">
                                    <option value="admin" <?= $u->getRole()->value === 'admin' ? 'selected' : '' ?>>
                                        Admin
                                    </option>
                                    <option value="chef_projet" <?= $u->getRole()->value === 'chef_projet' ? 'selected' : '' ?>>
                                        Chef de projet
                                    </option>
                                    <option value="membre" <?= $u->getRole()->value === 'membre' ? 'selected' : '' ?>>
                                        Membre
                                    </option>
                                </select>

                                <button type="submit" name="change_role"
                                    class="bg-purple-600 hover:bg-purple-500 px-3 py-1 rounded text-sm">
                                    Modifier
                                </button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>

        </table>
    </div>

</main>

</body>
</html>
