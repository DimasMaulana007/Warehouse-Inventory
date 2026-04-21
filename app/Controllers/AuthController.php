<?php

class AuthController {
    public function showLogin() {
        if (isset($_SESSION['user_id'])) {
            header("Location: ?route=dashboard");
            exit;
        }

        require_once "../app/Views/auth/login.php";
    }

    public function processLogin() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'] ?? '';
            $password = $_POST['password'] ?? '';

            $db = Database::getInstance()->getConnection();
            
            $stmt = $db->prepare("SELECT * FROM users WHERE username = :username AND is_active = TRUE LIMIT 1");
            $stmt->execute(['username' => $username]);
            $user = $stmt->fetch();

            if ($user) {
                if ($password === $user['password']) {
                    $_SESSION['user_id'] = $user['username'];
                    $_SESSION['user_role'] = $user['role'];
                    
                    // Migrate password to secure hash for future logins
                    $hashed = password_hash($password, PASSWORD_DEFAULT);
                    $upd = $db->prepare("UPDATE users SET password = :hash WHERE username = :usr");
                    $upd->execute(['hash' => $hashed, 'usr' => $user['username']]);

                    header("Location: ?route=dashboard");
                    exit;
                } elseif (password_verify($password, $user['password'])) {
                    $_SESSION['user_id'] = $user['username'];
                    $_SESSION['user_role'] = $user['role'];
                    header("Location: ?route=dashboard");
                    exit;
                }
            }
            
            $error = "Username atau password salah / tidak aktif.";
            require_once "../app/Views/auth/login.php";
        }
    }

    public function logout() {
        session_destroy();
        header("Location: ?route=");
        exit;
    }
}
?>
