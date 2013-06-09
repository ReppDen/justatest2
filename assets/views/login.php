<?php if ($error) {
    echo '<div class="alert-error">Введены не верные логин и пароль, по пробуйте еще раз</div>';
}
?>
<form method="POST">
    <fieldset>
        <legend>Авторизация</legend>
        <label>Email пользователя</label>
        <input type="email" name="username" placeholder="Email" required />
        <label>Пароль</label>
        <input type="password" name="password" required />
        <br/>
        <button type="submit" class="btn btn-success btn-std100">Вход</button>
        <br/>
        <a href="/login/register">Регистрация</a>
        <br/>
    </fieldset>
</form>
