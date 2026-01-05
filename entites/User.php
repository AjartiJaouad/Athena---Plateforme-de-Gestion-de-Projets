<?php
enum UserRole: string
{
    case ADMIN = 'admin';
    case EDITOR = 'editor';
    case USER = 'user';
}
class User
{

    private  $user_id;
    private  $username;
    private  $email;
    private  $password;
    private $role;
    public function __construct($user_id, $username, $email, $password, $role)
    {
        $this->user_id = $user_id;
        $this->username = $username;
        $this->email = $email;
        $this->setPassword($password);
        $this->role = $role;
    }
    public function  getUserID()
    {
        return $this->user_id;
    }
    public function getUserName()
    {
        return $this->username;
    }
    public function getEmail()
    {
        return $this->email;
    }

    public function getRole(): UserRole
    {
        return $this->role;
    }
    public function setUserNAme(
        $username
    ) {
        $this->username = $username;
    }

    public function setEmail($email)
    {
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->email = $email;
        }
    }
    public function setPassword($password)
    {
        $this->password = password_hash($password, PASSWORD_DEFAULT);
    }
    public function setRole($role)
    {
        $this->role = $role;
    }
    public function verifyPassword($inputPassword): bool
    {
        return password_verify($inputPassword, $this->password);
    }
    public function create($db)
    {
        $sql = "INSERT INTO user (username ,email ,password ,role) VALUES (:username , :email, :password, :role)";
        $stmt = $db->prepare($sql);
        $hashedPassword = password_hash($this->password, PASSWORD_DEFAULT);
        return $stmt->execute([
            ':username' => $this->username,
            ':email'   => $this->email,
            ':password' => $hashedPassword,
            ':role' => $this->role instanceof UserRole ? $this->role->value : $this->role

        ]);
    }
    public function update($db)
    {
        $sql = "UPDATE user SET username = :username ,email = :email , eole = :role WHERE user_id =id";
        $stmt = $db->prepare($sql);

        return $stmt->execute([
            ':username' => $this->username,
            ':email'   => $this->email,
            ':role' => $this->role instanceof UserRole ? $this->role->value : $this->role,
            ':id'       => $this->user_id

        ]);
    }
}
