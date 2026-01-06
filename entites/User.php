<?php
enum UserRole: string
{
    case ADMIN = 'admin';
    case CHEF_PROJET = 'chef_projet';
    case MEMBRE        = 'membre';
}

class User
{
    private int $user_id;
    private string $username;
    private string $email;
    private string $password;
    private UserRole $role;

    public function __construct(int $user_id, string $username, string $email, string $password, UserRole|string $role)
    {
        $this->user_id = $user_id;
        $this->setUsername($username);
        $this->setEmail($email);
        $this->setPassword($password);
        $this->setRole($role);
    }

    // Getters
    public function getUserID(): int
    {
        return $this->user_id;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getRole(): UserRole
    {
        return $this->role;
    }

    // setters
    public function setUsername(string $username): void
    {
        if (empty($username)) {
            throw new InvalidArgumentException("Le nom d'utilisateur ne peut pas être vide.");
        }
        $this->username = $username;
    }

    public function setEmail(string $email): void
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException("Email invalide.");
        }
        $this->email = $email;
    }

    public function setPassword(string $hashedPassword): void
    {
        $this->password = $hashedPassword;
    }

    public function setRole(UserRole|string $role): void
    {
        if ($role instanceof UserRole) {
            $this->role = $role;
            return;
        }

        $role = strtolower(trim($role));

        $this->role = match ($role) {
            'admin'        => UserRole::ADMIN,
            'chef_projet'  => UserRole::CHEF_PROJET,
            'membre'       => UserRole::MEMBRE,
            default => throw new InvalidArgumentException("Rôle invalide.")
        };
    }


    //  Verfication de password 
    public function verifyPassword(string $inputPassword): bool
    {
        return password_verify($inputPassword, $this->password);
    }

    // CRUD create user 
    public function create(PDO $db): bool
    {
        $sql = "INSERT INTO user (username, email, password, role) 
                VALUES (:username, :email, :password, :role)";
        $stmt = $db->prepare($sql);
        return $stmt->execute([
            ':username' => $this->username,
            ':email'    => $this->email,
            ':password' => $this->password,
            ':role'     => $this->role->value
        ]);
    }
    // update user
    public function update(PDO $db): bool
    {
        $sql = "UPDATE user SET username = :username, email = :email, role = :role 
                WHERE user_id = :id";
        $stmt = $db->prepare($sql);
        return $stmt->execute([
            ':username' => $this->username,
            ':email'    => $this->email,
            ':role'     => $this->role->value,
            ':id'       => $this->user_id
        ]);
    }

    public function delete(PDO $db): bool
    {
        $sql = "DELETE FROM user WHERE user_id = :id";
        $stmt = $db->prepare($sql);
        return $stmt->execute([':id' => $this->user_id]);
    }
    public function hashAndSetPassword(string $plainPassword): void
    {
        $this->password = password_hash($plainPassword, PASSWORD_DEFAULT);
    }


    //FIND Use
    public static function findById(PDO $db, int $id): ?self
    {
        $sql = "SELECT * FROM user WHERE user_id = :id";
        $stmt = $db->prepare($sql);
        $stmt->execute([':id' => $id]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($data) {
            return new self(
                $data['user_id'],
                $data['username'],
                $data['email'],
                $data['password'],
                $data['role']
            );
        }
        return null;
    }
 public static function findByEmail(PDO $db ,string $email ): ?self
 {
    $sql = "SELECT * FROM user WHERE email = :email";
    $stmt = $db->prepare($sql);
    $stmt ->execute([':email'=> $email]);
    $data = $stmt ->fetch(PDO::FETCH_ASSOC);
    if ($data){
        return new self(
            $data['user_id'],
            $data['username'],
            $data['email'],
            $data['password'],
            $data['role']
        );
    }
    return null ;

 }


}
