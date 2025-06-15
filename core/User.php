<?php
class User {
    private $db;
    private $name;
    private $phone;
    private $email;
    private $login;
    private $password;

    public function __construct($db) {
        $this->db = $db;
    }

    public function register($name, $phone, $email, $login, $password) {
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);
        $sql = "INSERT INTO users (name, phone, email, login, password) VALUES (:name, :phone, email, :login, :password)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':phone', $phone);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':login', $login);
        $stmt->bindParam(':password', $hashed_password);
        return $stmt->execute();
    }
}