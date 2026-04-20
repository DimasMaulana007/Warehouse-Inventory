<?php

class Controller {
    public function view($view, $data = []) {
        extract($data);
        
        // Mulai buffering output
        ob_start();
        $viewPath = "../app/Views/" . $view . ".php";
        if (file_exists($viewPath)) {
            require_once $viewPath;
        } else {
            echo "View file not found: " . htmlspecialchars($viewPath);
        }
        $content = ob_get_clean();

        // Sertakan template utama
        require_once "../app/Views/layout/main.php";
    }
}
?>
