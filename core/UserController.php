<?php 

class UserController{

    public function registrationGet() {
        // Возврат шаблона регистрации
        return new View("registration");
    }

    public function registrationPost() {
        require_once 'db.php';
        $login = $_POST['login'];
        $name = $_POST['name'];
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $age = $_POST['age'];
        
        $result = $conn->query("SELECT * FROM `users` WHERE login='$login'");
        $array = $result->fetch_assoc();
        
        if (strlen($_POST['password'])<6) {
            echo 'Пароль должен содержать минимум 6 символов';
        }
        else if ($array>0) {
            echo 'Пользователь с таким логином уже существует';
        }
        else {
            $conn->query("INSERT INTO `users`(login, name, password, date_of_birth) VALUES('$login', '$name', '$password', '$age')");
    
            $_SESSION['name'] = $name;
            $_SESSION['age'] = $age;
            $_SESSION['password'] = $_POST['password'];
            $_SESSION['login'] = $login;
            return new View('index');
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