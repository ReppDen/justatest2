<h3>Расчет выплат ОУК ПГГПУ</h3>
<form method="POST" action="/oukcalc/calc_money">
    <fieldset>
        <div class="alert alert-error">
            Не забудьте проверить, что все расчеты баллов для <a href="/ouk/list_ouk">ОУК</a> и <a href="/oukuser/list_ouk">сотрудников ОУК</a> заполнены!
        </div>
        <label>Фонд стимулирущих выплат университета в рублях</label>
        <input id="fond" name="money" type="number" min="1" value="<?php echo $fond;?>" required=""/>
        <label>Этап</label>
        <?php
        foreach ($stages as $s) {
            echo '<input type="radio" name="stage" value="'.$s->id.'" required />'.$s->name.'<br/>';
        }
        ?>
        <br/>
        <label>Год</label>
        <select id="year" name="year" class="year">
            <?php
            $year = date("Y");
            for ($i = 2012; $i< date("Y") + 2; $i++) {
                if ($i == $year) {
                    echo '<option value="'.$i.'" selected>'.$i.'</option>';
                } else {
                    echo '<option value="'.$i.'">'.$i.'</option>';
                }
            }
            ?>
        </select>
        <br/>
        Количество штатных преподавателей: <br/><input type="number" name="all_pps" value="<?php echo $all;?>" min=0; required="" />
        <div class="alert alert-danger">значение подсчитано автоматически, основываясь на данных факультетов, если цифра не совпадает с реальной - измените!</div>
        <br/>
        <button type="submit" class="btn">Рассчитать</button>
    </fieldset>
</form>