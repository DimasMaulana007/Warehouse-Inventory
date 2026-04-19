<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistem IPAK V2</title>
    <style>
        body { font-family: Roboto, sans-serif; background: #e9ecef; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; }
        .login-box { background: white; padding: 30px; border-radius: 8px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); width: 100%; max-width: 380px; }
        .login-box h2 { text-align: center; margin-bottom: 25px; color: #333; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; color: #666; font-size: 14px;}
        input[type="text"], input[type="password"] { width: 100%; padding: 10px; border: 1px solid #ced4da; border-radius: 4px; box-sizing: border-box; }
        button { width: 100%; padding: 12px; background: #007bff; color: white; border: none; border-radius: 4px; cursor: pointer; font-size: 16px; font-weight: bold;}
        button:hover { background: #0056b3; }
        .alert { color: #842029; background-color: #f8d7da; padding: 10px; border-radius: 4px; margin-bottom: 15px; text-align: center; font-size: 14px;}
        .footer {text-align: center; margin-top:20px; font-size:12px; color: #999;}
    </style>
</head>
<body>
    <div class="login-box">
        <h2>Sistem IPAK V2</h2>
        <?php if (!empty($error)): ?>
            <div class="alert"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>
        <form action="?route=login" method="POST">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" name="username" id="username" autocomplete="off" required autofocus>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" name="password" id="password" required>
            </div>
            <button type="submit">Masuk</button>
        </form>
        <div class="footer">Versi Core MVC Aman (Phase 1)</div>
    </div>
</body>
</html>
