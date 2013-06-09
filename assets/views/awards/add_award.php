<h3>Добавить расчет стимулирующих выплат</h3>
<form id="form" method="POST" action="/award/fill_stage">
<!--    <fieldset>-->

        <div class="col_container">
                    <div class="column">
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
                    </div>
                    <div class="column" style="width:690px;">
                        <label>Количество студентов факультета (приведенный контингент) или студентов,
                            обслуживаемых кафедрой</label>
                        <input type="number" id="nf" name="nf" value="<?php echo get_val($nf);?>" required/>
                        <br/>

                        <label>Количество штатных преподавателей на факультете (кафедре)</label>
                        <input type="number" id="nprf" name="nprf" value="<?php echo get_val($nprf);?>" required/>
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
                if (vals[i].startsWith("stage")) {
                    stage = vals[i].substr(vals[i].lastIndexOf("=")+1);
                }
            }
            $.ajax({
                type: "GET",
                url: "/ajax/check_award",
                data: {
                    id: $('#faculty').val(),
                    stage: stage,
                    year:$('#year').val()
                },
                success: function (res) {
                    if (res) {
                        console.log("вопрос");
                        var year = $("#year").val();
                        var stage = $("#stage").val();
                        if (confirm("Расчет для выбранного года и этапа уже существет. Перезаписать имеющийся?")) {
                            $("#overwrite").val(1);
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
        $("#faculty").trigger('change');
        $("#faculty").change(function() {
            $.ajax({
                type: "GET",
                url: "/ajax/get_fac_info",
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
                error: function(res) {
                    $.jGrowl("Произошла ошибка во время запроса к серверу");
                }
            });
        });




    });
</script>


<?php
function get_val($a) {
    if ($a != null) {
        echo $a;
    } else {
        echo 0;
    }
}
?>