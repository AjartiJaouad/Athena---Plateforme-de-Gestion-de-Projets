<?php

class AuthService
{
    public static function check(): void
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: login.php');
            exit;
        }
    }

    public static function user(PDO $db): User
    {
        $user = User::findById($db, $_SESSION['user_id']);
        if (!$user) {
            session_destroy();
            header('Location: login.php');
            exit;
        }
        return $user;
    }

    public static function requireRole(UserRole $role, User $user): void
    {
        if ($user->getRole() !== $role) {
            die('Accès refusé');
        }
    }
}
