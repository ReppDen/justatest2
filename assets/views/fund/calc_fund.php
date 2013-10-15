<h3>Расчет фонда стимулурующих выплат для университета</h3>
<form method="POST">
    <fieldset>
        <div class="alert alert-error">
            Не забудьте проверить, что все расчеты баллов для <a href="/award/list_award">факультетов</a> и <a href="/awarduser/list_award">сотрудников</a> заполнены!
        </div>
        <label>Фонд стимулирущих выплат университета в рублях</label>
        <input id="fsu" name="fsu" type="number" required=""/>
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
            for ($i = 2012; $i< $year + 2; $i++) {
                if ($i == $year) {
                    echo '<option value="'.$i.'" selected>'.$i.'</option>';
                } else {
                    echo '<option value="'.$i.'">'.$i.'</option>';
                }
            }
            ?>
        </select>
        <br/>
        <br/>
<!--        <label>Количество студентов университета (приведенный контингент)</label>-->
<!--        <input type="number" name="nu" value="--><?php //getVal($nu_calc);?><!--" required/>-->
<!--        <br/>-->
<!--        <label>Количество штатных преподавателей в университете</label>-->
<!--        <input type="number" name="npru" value="--><?php //getVal($npru_calc);?><!--" required/>-->

        <button type="submit" class="btn">Рассчитать</button>
    </fieldset>
</form>
