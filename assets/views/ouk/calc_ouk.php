<h3>Добавить расчет стимулирующих выплат для общеуниверситетской кафедры</h3>
<form id="form" method="POST" action="/ouk/fill_ouk">
    <div class="col_container">
        <div class="column">
            <label>Факультет</label>
            <?php
                echo '<select id="faculty" name="faculty">';
                foreach ($faculties as $f) {
                    echo '<option value="' . $f->idouk_faculty . '">' . $f->name . '</option>';
                }
                echo '</select>';

            ?>
            <label>Этап</label>
            <?php
            $i = 0;
            foreach ($stages as $s) {
                $i++;
                echo '<input type="radio" id="stage[]" name="stage" value="' . $s->id . '" required />' . $s->name . '<br/>';
            }
            ?>
            <br/>
            <label>Год</label>
            <select id="year" name="year" class="year">
                <?php
                $year = date("Y");
                for ($i = 2012; $i < $year + 2; $i++) {
                    if ($i == $year) {
                        echo '<option value="' . $i . '" selected>' . $i . '</option>';
                    } else {
                        echo '<option value="' . $i . '">' . $i . '</option>';
                    }
                }
                ?>
            </select>

            <br/>
        </div>
        <div class="column" style="width:690px;">
            <label>Количество штатных преподавателей на кафедре</label>
            <input type="number" id="nprf" name="nprf" min="0" max="100000" value="<?php echo get_val($nprf); ?>"
                   required/>
            <br/>
        </div>
    </div>
    </fieldset>
    <button type="button" class="btn" id="next_btn">Далее</button>
    <button type="submit" class="hidden" id="submit_btn">submit</button>
</form>
<script>
    $(document).ready(function () {
        $("#next_btn").click(function () {
            // если форма не валидна - выходим
            var form = $('#form')[0];
            if (!form.checkValidity()) {
                $('#form').find('#submit_btn').click();
                return;
            }
            if (hand_made_validation() != 0) {
                return;
            }

            // ищем этап и в путь
            var s = $('#form').serialize();
            var vals = s.split("&");
            var stage = 0;
            for (var i = 0; i < vals.length; i++) {
                var s = vals[i];
                if (s.indexOf("stage") == 0) {
                    stage = s.substr(s.lastIndexOf("=") + 1);
                }
            }
            $.ajax({
                type: "GET",
                url: "/ajax/check_ouk",
                data: {
                    id: $('#faculty').val(),
                    stage: stage,
                    year: $('#year').val()
                },
                success: function (res) {
                    if (res) {
                        console.log("вопрос");
                        var year = $("#year").val();
                        var stage = $("#stage").val();
                        if (confirm("Расчет для выбранного года и этапа уже существет. После перезаписи нужно запустить перерасчет премий ОУК. Перезаписать?")) {
                            $("#overwrite").val(1);
                            $("#form").submit();
                        }
                    } else {
                        $("#form").submit();
                    }
                },
                error: function (res) {
                    $.jGrowl("Произошла ошибка во время запроса к серверу");
                }
            });
        });
        $("#faculty").trigger('change');
        $("#faculty").change(function () {
            $.ajax({
                type: "GET",
                url: "/ajax/get_fac_info_ouk",
                data: {
                    id: $('#faculty').val()
                },
                success: function (res) {
                    var obj = jQuery.parseJSON(res);
                    if (obj != null) {
                        console.log(obj);
                        console.log(obj.nf);
                        console.log(obj.nprf);
                        $("#nf").val(Number(obj.nf));
                        $("#nprf").val(Number(obj.nprf));
                    }
                },
                error: function (res) {
                    $.jGrowl("Произошла ошибка во время запроса к серверу");
                }
            });
        });


    });
</script>


<?php
function get_val($a)
{
    if ($a != null) {
        echo $a;
    } else {
        echo 0;
    }
}

?>