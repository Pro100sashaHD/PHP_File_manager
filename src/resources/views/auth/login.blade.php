<form method="POST" action="{{ route('login') }}">
    @csrf
    <input type="email" name="email" placeholder="Email" required>
    <input type="password" name="password" placeholder="Пароль" required>
    <button type="submit">Войти</button>
    <div style="margin-top: 15px; text-align: center;">
        <span>Нет аккаунта?</span>
            <a href="{{ route('register') }}" class="ant-btn ant-btn-link">Зарегистрироваться</a>
    </div>
</form>