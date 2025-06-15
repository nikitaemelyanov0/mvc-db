<?php 

require_once 'db.php';

class UserController{

    protected $userModel;

    public function __construct() {
        $db = (new Database())->getConnection();
        $this->userModel = new User($db);
    }

    // Показ формы регистрации (GET)
    public function registerationGet() {
        return new View("registration");
    }

    // Обработка формы (POST)
    public function registerationPost() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = trim($_POST['name']);
            $phone = trim($_POST['phone']);
            $email = trim($_POST['email']);
            $login = trim($_POST['login']);            
            $password = trim($_POST['password']);
            
            if ($this->userModel->register($name, $phone, $email, $login, $password)) {
                header("Location: /index.php");
                exit;
            } else {
                die("Ошибка регистрации!");
            }
        }
    }

    public function authorizationGet() {
        // Возврат шаблона авторизации
        return new View("authorization");
    }

    public function authorizationPost() {
        require_once 'db.php';
        $login = $_POST['login'];
        $password = $_POST['password'];

        $result = $conn->query("SELECT * FROM `users` WHERE login='$login'");
        $array = $result->fetch_assoc();
        if ($result->num_rows>0) {
            $passhash = $array['password'];
        }

        if ($result->num_rows>0 && (password_verify($password, $passhash)===true)) {
            $_SESSION['name'] = $array['name'];
            $_SESSION['age'] = $array['date_of_birth'];
            $_SESSION['password'] = $_POST['password'];
            $_SESSION['login'] = $login;
            return new View('index');
        }
        else echo 'Неправильно набран логин или пароль'; 
    }

    public function changeinfoGet() {
        return new View("changeinfo");
    }
    
    public function changeinfoPost() {
        require_once 'db.php';
        $password = $_POST['password'];
        $newpassword = $_POST['newpassword'];
        $login = $_SESSION['login'];

        if ($password==$_SESSION['password']) {
            $newpasswordhash = password_hash($newpassword, PASSWORD_DEFAULT);
            $conn->query("UPDATE `users` SET `password` = '$newpasswordhash' WHERE `users`.`login` = '$login'");
            $_SESSION['password'] = $newpassword;
            header('location: /');
        }
        else echo 'Неправильно набран пароль'; 
    }
}

