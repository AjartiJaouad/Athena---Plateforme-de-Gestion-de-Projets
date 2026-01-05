<?php
enum UserRole: string {
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
    public function __construct( $user_id ,$username , $email ,$password , $role )
    {
        $this->user_id = $user_id;
        $this->username = $username;
        $this->email = $email;
        $this->setPassword($password);     
        $this->role = $role;
    }
    public function  getUserID(){
        return $this ->user_id;
    }
    public function getUserName(){
        return $this ->username;
    }
    public function getEmail(){
        return $this-> email ;
    }
  
    public function getRole():UserRole{
        return $this -> role;
    }
    public function setUserNAme($username
    ){
        $this -> username =$username ;
    }
 
    public function setEmail($email){
        if(filter_var($email ,FILTER_VALIDATE_EMAIL)){
            $this ->email =$email ;
        }
    }
      public function setPassword($password)
    {
        $this->password = password_hash($password, PASSWORD_DEFAULT);
    }
    public function setRole($role){
        $this -> role =$role ;
    }
    public function verifyPassword($inputPassword): bool {
        return password_verify($inputPassword, $this->password);
    }
}
