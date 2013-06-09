<h3>Рассчет фонда стимулурующих выплат для преподавателей</h3>
<form id="form" method="POST">
    <fieldset>
        <label>Факультет</label>
        <select id="faculty" name="faculty">
            <?php
            foreach($faculties as $f) {
                echo '<option value="'.$f->id.'">'.$f->name.'</option>';
            }
            ?>
        </select>
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
        <br/>
<!--        <label>Количество студентов университета (приведенный контингент)</label>-->
<!--        <input type="number" name="nu" value="--><?php //getVal($nu_calc);?><!--" required/>-->
<!--        <br/>-->
<!--        <label>Количество штатных преподавателей в университете</label>-->
<!--        <input type="number" name="npru" value="--><?php //getVal($npru_calc);?><!--" required/>-->

        <button id="next_btn" type="button" class="btn">Рассчитать</button>
        <button type="submit" class="hidden" id="submit_btn" />
    </fieldset>
</form>

<script>
    $(document).ready(function() {
        $("#next_btn").click(function() {
            // если форма не валидна - выходим
            var form = $('#form')[0];
            if (!form.checkValidity()) {
                $('#form').find('#submit_btn').click();
                return;
            }

            // ищем этап и в путь
            var s = $('#form').serialize();
            var vals = s.split("&");
            var stage = 0;
            for (var i=0; i < vals.length; i++) {
                if (vals[i].startsWith("stage")) {
                    stage = vals[i].substr(vals[i].lastIndexOf("=")+1);
                }
            }
            $.ajax({
                type: "GET",
                url: "/ajax/check_funduser_calc_count",
                data: {
                    id: $('#faculty').val(),
                    stage: stage,
                    year:$('#year').val()
                },
                success: function (res) {
                    if (res == 0) {
                        console.log("вопрос");
                        if (confirm("Расчет для факультета, года и этапа еще не существует расчетов баллов, расчет премий не возможен. \n Перейти на страницу расчета баллов?")) {
                            location.href="/awarduser/";
                        }
                    } else {
                        $("#form").submit();
                    }
                },
                error: function(res) {
                    $.jGrowl("Произошла ошибка во время запроса к серверу");
                }
            });
        });
    });
</script>
