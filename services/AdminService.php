<?php


require_once __DIR__ . '/../entites/User.php';

class AdminService
{


    private PDO $db;
    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function getAllUsers(): array
    {
        $stmt = $this->db->prepare("SELECT * FROM user ORDER BY user_id ASC");
        $stmt->execute();
        $users = [];
        while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $users[] = new User(
                $data['user_id'],
                $data['username'],
                $data['email'],
                $data['password'],
                $data['role']
            );
        }
        return $users;
    }

    public function setUserRole(int $userId, UserRole $role): bool
    {
        $stmt = $this->db->prepare("UPDATE user SET role = :role WHERE user_id = :id");
        return $stmt->execute([
            ':role' => $role->value,
            ':id' => $userId
        ]);
    }
    public function toggleUserActive(int $userId, bool $active): bool
    {
        $stmt = $this->db->prepare("UPDATE user SET active = :active WHERE user_id = :id");
        return $stmt->execute([
            ':active' => $active ? 1 : 0,
            ':id' => $userId
        ]);
    }

    public function getStats(): array
    {
        $stats = [];

        
        $stmt = $this->db->query("SELECT role, COUNT(*) as count FROM user GROUP BY role");
        $stats['users_by_role'] = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);

        $stmt = $this->db->query("SELECT COUNT(*) as total FROM project");
        $stats['total_projects'] = $stmt->fetchColumn();

     
        $stmt = $this->db->query("SELECT COUNT(*) as total FROM task");
        $stats['total_tasks'] = $stmt->fetchColumn();

        return $stats;
    }
}
