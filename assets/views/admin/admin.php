<h3>Консоль администратора</h3>
<div>
    <h5>Расчеты</h5>
    <a href="/award">Добавить расчет баллов факультета</a><br/>
    <a href="/awarduser">Добавить расчет баллов преподавателя</a><br/>
    <?php
    if ($super) {
//        echo '<a href="/fund/calc_fund">Рассчитать фонд стимулурующих выплат для университета</a><br/>';
        echo '<a href="/fund/calc_fund_auto">[Автоматический] Расчитать фонд выплат за этап для преподавателей</a><br/>';
        echo '<strike><a href="/fund/calc_fund">[Ручной. Шаг 1] Расчитать фонд стимулурующих выплат для университета</a></strike><br/>';
        echo '<strike><a href="/funduser/calc_fund">[Ручной. Шаг 2] Расчитать фонд стимулурующих выплат для преподавателей</a></strike><br/>';
        echo '<br/>';
        echo '<a href="/uvp">[Автоматический] Расчитать выплат УВП ПГГПУ</a><br/>';
    }
    ?>
    <hr/>
    <h5>Просмотр</h5>
    <a href="/award/list_award">Список расчетов баллов по факультетам</a><br/>
    <a href="/awarduser/list_award">Список расчетов по преподавателям</a><br/>
    <?php
    if ($super) {
        echo '<a href="/fund/list_calc">Список всех сформированных расчетов по университету</a><br/>
                <a href="/funduser/list_fund">Список выплат сотрудникам по факультетам</a><br/>
                <a href="/funduser/list_ball">Список баллов сотрудников по факультетам</a><br/>';

        echo '<br/><a href="/uvp/list_calc">Список расчетов баллов УВП</a><br/>
                <a href="/uvp/list_payments">Список расчетов выплат УВП</a><br/>';

    }
    ?>
</div>