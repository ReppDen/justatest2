<h3>Добавить расчет стимулирующих выплат</h3>
<form id="form" method="POST" action="/oukuser/fill_stage">
    <!--    <fieldset>-->

    <div class="col_container">
        <div class="column">
            <label>Преподаватель</label>
            <select id="user" name="user" style="width:400px;">
                <?php
                if ($super) {
                    foreach($users as $f) {
                        echo '<option value="'.$f->id.'">'.$f->fio.' '.$f->oukfaculty->name.'</option>';
                    }
                } else {
                    foreach($users as $f) {
                        echo '<option value="'.$f->id.'">'.$f->fio.'</option>';
                    }
                }


                ?>
            </select>

            <label>Этап</label>
            <?php
            $i = 0;
            foreach ($stages as $s) {
                $i++;
                echo '<input type="radio" id="stage[]" name="stage" value="'.$s->id.'" required />'.$s->name.'<br/>';
            }
            ?>
            <br/>
            <label>Год</label>
            <!--        <input type="number" name="year" value="--><?php //echo date("Y") ?><!--" required >-->
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
        </div>
    </div>
    </fieldset>
    <button type="button" class="btn" id="next_btn">Далее</button>
    <button type="submit" class="hidden" id="submit_btn">submit</button>

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
                if (vals[i].indexOf("stage") == 0) {
                    stage = vals[i].substr(vals[i].lastIndexOf("=")+1);
                }
            }
            $.ajax({
                type: "GET",
                url: "/ajax/check_oukuser",
                data: {
                    id: $('#user').val(),
                    stage: stage,
                    year:$('#year').val()
                },
                success: function (res) {
                    if (res) {
                        console.log("вопрос");
                        var year = $("#year").val();
                        var stage = $("#stage").val();
                        if (confirm("Расчет для выбранного года и этапа уже существет. Перезаписать имеющийся?")) {
                            $("#form").submit();
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