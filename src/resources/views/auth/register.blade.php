<form action="/register" method="POST">
    @csrf
    <input type="text" name="name" placeholder="Имя" required>
    <input type="email" name="email" placeholder="Email" required>
    <input type="password" name="password" placeholder="Пароль" required>
    <input type="password" name="password_confirmation" placeholder="Повторите пароль" required>
    <button type="submit">Зарегистрироваться</button>
</form>