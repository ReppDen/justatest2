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
        echo '<a href="/uvp">Добавить расчет баллов УВП ПГГПУ</a><br/>';
        echo '<a href="/uvp/calc_payment">[Автоматический] Расчитать выплат УВП ПГГПУ</a><br/>';
        echo '<br/>';
        echo '<a href="/ouk/">Добавить расчет баллов общеуниверситетской кафедры</a><br/>';
        echo '<a href="/oukuser/">Добавить расчет баллов преподавателя общеуниверситетской кафедры</a><br/>';
        echo '<a href="/oukcalc/calc_payment">[Автоматический] Расчитать выплат ОУК ПГГПУ</a><br/>';

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
                <a href="/uvp/list_payment">Список расчетов выплат УВП</a><br/>
                <a href="/uvp/list_uvp">Список расчетов УВП</a><br/>';
        echo '<br/><a href="/ouk/list_ouk/">Список расчетов баллов ОУК</a><br/>
                <a href="/oukuser/list_ouk">Список расчетов баллов сотрудников ОУК</a><br/>
                <a href="/oukcalc/list_operation">Список расчетов выплат ОУК</a><br/>';
        echo '<hr/><br/><b>Настройки</b>';
        echo '<br/><a href="/admin/edit_roles">Настройка ролей пользователей</a>';

    }
    ?>
</div>