<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Вход</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/antd/4.24.15/antd.min.css" />
    <style>
        body { background: #f0f2f5; display: flex; align-items: center; justify-content: center; height: 100vh; margin: 0; }
        .login-card { background: #fff; padding: 40px; border-radius: 8px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); width: 100%; max-width: 400px; }
        .login-title { text-align: center; margin-bottom: 24px; font-weight: 600; font-size: 24px; color: #1890ff; }
        .ant-input { margin-bottom: 16px; height: 40px; }
        .ant-btn-primary { width: 100%; height: 40px; font-size: 16px; }
    </style>
</head>
<body>
    <div class="login-card">
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="ant-form-item">
                <input type="email" name="email" class="ant-input" placeholder="Email" required autofocus>
            </div>
            <div class="ant-form-item">
                <input type="password" name="password" class="ant-input" placeholder="Пароль" required>
            </div>
            <button type="submit" class="ant-btn ant-btn-primary">
                Войти
            </button>
            <div style="margin-top: 16px; text-align: center; color: rgba(0,0,0,0.45);">
                Нет аккаунта? <a href="{{ route('register') }}">Зарегистрироваться</a>
            </div>
        </form>
    </div>
</body>
</html>