<?php
session_start();
require '../config/database.php';
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$user_id = $_SESSION['user_id'];
$message = '';
$stmt = $con->prepare("SELECT username ,email ,role FROM user WHERE user_id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (isset($_POST['update'])) {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    if (!empty($password)) {
        $hash =  password_hash($password, PASSWORD_DEFAULT);
        $stmt = $con->prepare("UPDATE user SET username =? ,email = ? WHERE user_id = ?");

        $stmt->execute([
            $username,
            $email,
            $user_id
        ]);
    } else {
        $stmt = $con->prepare("UPDATE user SET username=?, email=? WHERE user_id=?");
        $stmt->execute([$username, $email, $user_id]);
    }
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



        <form method="POST" class="space-y-6">

            <div>
                <label class="block text-white text-sm mb-2">Nom d'utilisateur</label>
                <input type="text" name="username" value="<?= htmlspecialchars($user['username']) ?>"

                    class="w-full px-3 py-2 bg-transparent text-white border-b border-slate-500 focus:border-purple-400 outline-none">
            </div>

            <div>
                <label class="block text-white text-sm mb-2">Email</label>
                <input type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>"

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
            <p>Rôle : <strong><?= $user['role'] ?></strong></p>
            </p>
        </div>

        <div class="mt-6 flex justify-between text-sm">
            <a href="dashboard.php" class="text-purple-400 hover:underline">Dashboard</a>
            <a href="logout.php" class="text-red-400 hover:underline">Déconnexion</a>
        </div>

    </div>

</body>

</html>