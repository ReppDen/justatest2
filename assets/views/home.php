<h3>Пользователь <?php echo $user->fio;?></h3>
<div>
    <a href="/award/list_award">Посмотреть список расчетов по факультетам</a><br/>
    <a href="/awarduser/list_award">Посмотреть список расчетов по пользователям</a><br/>
    <?php
    if ($user->role == 'admin') {
        echo '<a href="/admin">Консоль администратора</a><br/>';
    }
    ?>
    <a href="/user?id=<?php echo $user->id;?>">Изменить данные пользователя</a><br/>
    <a href="/login/logout">Выход из системы</a>
</div>