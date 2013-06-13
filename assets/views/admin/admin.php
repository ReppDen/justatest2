<h3>Консоль администратора</h3>
<div>
    <h5>Расчеты</h5>
    <a href="/award">Добавить расчет баллов факультета</a><br/>
    <a href="/awarduser">Добавить расчет баллов преподавателя</a><br/>
    <?php
    if ($super) {
        echo '<a href="/fund/calc_fund">Рассчитать фонд стимулурующих выплат для университета</a><br/>';
    }
    ?>
    <hr/>
    <h5>Просмотр</h5>
    <a href="/award/list_award">Список расчетов баллов по факультетам</a><br/>
    <a href="/awarduser/list_award">Список расчетов по преподавателям</a><br/>
    <?php
    if ($super) {
        echo ' <a href="/fund/list_calc">Список всех сформированных расчетов по университету</a><br/>
                <a href="/funduser/list_fund">Список выплат сотрудникам</a><br/>';
    }
    ?>
</div>