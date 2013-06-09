<h3>Рассчет фонда стимулурующих выплат для университета</h3>
<form method="POST">
    <fieldset>
        <label>Фонд стимулирущих выплат университета в рублях</label>
        <input id="fsu" name="fsu" type="number" required=""/>
        <label>Год</label>
        <select id="year" name="year" class="year">
            <?php
            $year = date("Y");
            for ($i = 1970; $i< $year + 20; $i++) {
                if ($i == $year) {
                    echo '<option value="'.$i.'" selected>'.$i.'</option>';
                } else {
                    echo '<option value="'.$i.'">'.$i.'</option>';
                }
            }
            ?>
        </select>
        <br/>
        <button type="submit" class="btn">Рассчитать</button>
    </fieldset>
</form>
