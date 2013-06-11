<form method="POST" xmlns="http://www.w3.org/1999/html">
    <fieldset>
        <legend>Редактирование инфорации пользователя</legend>
        <label>Email пользователя</label>
        <input type="email" name="email" value="<?php echo $u->email; ?>" required />
        <label>ФИО пользователя</label>
        <input type="text" name="fio" value="<?php echo $u->fio; ?>" required/>
        <label>Пароль</label>
        <input type="password" name="password"/>
        <br/>
        Ставка от 0 до 1
        <br/>
        <input type="number" name="rate" value="<?php echo $u->rate;?>" required/>
        <br/>
        <input type="checkbox" name="main" <?php if ($u->main_job) { echo 'checked'; }?> >Оснвоное место работы</input>
        <br/>
        <label>Факультет</label>
        <select name="faculty">
            <?php
                foreach($faculties as $f) {
                    if ($f->id == $u->faculty->id) {
                        echo '<option value="'.$f->id.'" selected>'.$f->name.'</option>';
                    } else {
                        echo '<option value="'.$f->id.'">'.$f->name.'</option>';
                    }

                }
            ?>
        </select>
        <input type="hidden" name="uid" value="<?php echo $u->id; ?>">
        <br/>
        <button type="submit" class="btn btn-success btn-std100">Сохранить</button>
        <br/>
    </fieldset>
</form>
