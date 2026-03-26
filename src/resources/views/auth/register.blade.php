<form action="/register" method="POST">
    @csrf
    <input type="text" name="name" placeholder="Имя" required>
    <input type="email" name="email" placeholder="Email" required>
    <input type="password" name="password" placeholder="Пароль" required>
    <input type="password" name="password_confirmation" placeholder="Повторите пароль" required>
    <button type="submit">Зарегистрироваться</button>
    <div style="margin-top: 15px; text-align: center;">
        <span>Уже есть аккаунт?</span>
            <a href="{{ route('login') }}" class="ant-btn ant-btn-link">Войти</a>
    </div>
</form>