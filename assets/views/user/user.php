<form method="POST" xmlns="http://www.w3.org/1999/html">
    <fieldset>
        <legend>Редактирование инфорации пользователя</legend>
        <label>Email пользователя</label>
        <input type="email" name="username" placeholder="Email" required />
        <label>Пароль</label>
        <input type="password" name="password" required />
        <br/>
<!--        <label></label>-->
        <input type="checkbox" name="full_day" required checked> Основное место работы</input>
        <br/>
        <label>Ставка (от 0 до 1)</label>
        <input type="password" name="work_rate" required />
        <div>
            <a href="/user/save" class="btn btn-success btn-std">Cохранить</a>
            <a href="/" class="btn" style="width: 82px;">Отмена</a>
        </div>
        <br/>
    </fieldset>
</form>
