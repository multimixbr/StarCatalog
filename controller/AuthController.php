<?php

require_once '../config/database.php';

class AuthController
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = dbConnect();
    }

    public function register($full_name, $email, $password)
    {
        if (empty($full_name) || empty($email) || empty($password)) {
            return ['success' => false, 'message' => 'All fields are required.'];
        }

        try {
            $stmt = $this->pdo->prepare("SELECT id FROM users WHERE email = '{$email}'");
            $stmt->execute();
            if ($stmt->fetch()) {
                return ['success' => false, 'message' => 'Email already exists.'];
            }

            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

            $stmt = $this->pdo->prepare("INSERT INTO users (full_name, email, password) VALUES ('{$full_name}', '{$email}', '{$hashedPassword}')");
            if ($stmt->execute()) {
                return ['success' => true, 'message' => 'Registration successful!'];
            }
        } catch (PDOException $e) {
            return ['success' => false, 'message' => 'Error: ' . $e->getMessage()];
        }

        return ['success' => false, 'message' => 'Registration failed.'];
    }

    public function login($email, $password)
    {
        if (empty($email) || empty($password)) {
            return ['success' => false, 'message' => 'All fields are required.'];
        }

        try {
            $stmt = $this->pdo->prepare("SELECT * FROM users WHERE email = '{$email}'");
            $stmt->execute();
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user && password_verify($password, $user['password'])) {
                session_start();
                $_SESSION['user'] = [
                    'id' => $user['id'],
                    'full_name' => $user['full_name'],
                    'email' => $user['email']
                ];
                return ['success' => true, 'message' => 'Login successful.'];
            }
        } catch (PDOException $e) {
            return ['success' => false, 'message' => 'Error: ' . $e->getMessage()];
        }

        return ['success' => false, 'message' => 'Invalid email or password.'];
    }

    public function logout()
    {
        session_start();
        session_unset();
        session_destroy();
        header("Location: ../view/login.php");
        exit();
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $auth = new AuthController();
    $action = $_POST['action'] ?? '';

    switch ($action) {
        case 'register':
            $response = $auth->register($_POST['full_name'], $_POST['email'], $_POST['password']);
            echo json_encode($response);
            break;
        case 'login':
            $response = $auth->login($_POST['email'], $_POST['password']);
            echo json_encode($response);
            break;
        case 'logout':
            $auth->logout();
            break;
    }
}
