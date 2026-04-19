<?php
class DashboardController {
    public function index() {
        if (!isset($_SESSION['user_id'])) {
            header("Location: ?route=");
            exit;
        }

        echo "<div style='font-family:sans-serif; padding:50px; text-align:center;'>";
        echo "<h1>Selamat Datang di Dasbor, " . htmlspecialchars($_SESSION['user_id']) . "</h1>";
        echo "<p>Role Sistem Anda: <strong>" . htmlspecialchars($_SESSION['user_role']) . "</strong></p>";
        echo "<p><a href='?route=logout' style='color:red; text-decoration:none; padding:10px; border:1px solid red; border-radius:4px;'>Keluar (Logout)</a></p>";
        echo "</div>";
    }
}
?>
