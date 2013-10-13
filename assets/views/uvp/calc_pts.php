<h3>Расчет выплат УВП ПГГПУ</h3>
<form method="POST" action="/uvp/fill_stage">
    <fieldset>
        <label>Сотрудник</label>
        <select id="user" name="user">
            <?php
            foreach ($users as $u) {
                echo '<option value="'.$u->id.'">'.$u->fio.'</option>';
            }
            ?>
        </select>
        <label>Этап</label>
        <?php
        foreach ($stages as $s) {
            echo '<input type="radio" name="stage" value="'.$s->iduvp_stage.'" required />'.$s->name.'<br/>';
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
        <button type="submit" class="btn">Рассчитать</button>
    </fieldset>
</form>