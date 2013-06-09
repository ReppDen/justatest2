<?php if ($error != null) {
    echo '<div class="alert-error">'.$error.'</div>';
}
?>
<form method="POST">
    <fieldset>
        <legend>Регистрация</legend>
        <label>Email пользователя</label>
        <input type="email" name="username" placeholder="Email" required />
        <label>ФИО пользователя</label>
        <input type="text" name="fio" placeholder="ФИО" required/>
        <label>Пароль</label>
        <input type="password" name="password" required/>
        <br/>
        <label>Факультет</label>
        <select name="faculty">
            <?php
            foreach($faculties as $f) {
                echo '<option value="'.$f->id.'">'.$f->name.'</option>';
            }
            ?>
        </select>
        <br/>
        <button type="submit" class="btn btn-success btn-std100">Регистрация</button>
        <br/>
        <a href="/">На главную</a>
    </fieldset>
</form>
