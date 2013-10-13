<?php
function show_process($code, $text) {
            echo $text.'
        <input type="hidden" name="'.$code.'_name" value="'.$text.'"/>
        <br/>
        <select name="'.$code.'" required style="width:260px;">
            <option value="0.0">Работа не выполнялась</option>
            <option value="0.5">Выполнена неудовлетворительно</option>
            <option value="1.0">Выполнена удовлетворительно</option>
            <option value="1.5">Выполнена хорошо</option>
            <option value="2.0">Выполнена отлично</option>
        </select>
        <br/>';
        }
?>

<form method="POST" id="form" action="/uvp/save_stage">
    <fieldset>
        <input type="hidden" name="stage_id" value="<?php echo $stage->iduvp_stage; ?>"/>
        <input type="hidden" name="year" value="<?php echo $year; ?>"/>
        <input type="hidden" name="user" value="<?php echo $user_id; ?>"/>

        <legend>Расчет баллов стимулирующих выплат за <?php echo $stage->name?></legend>
        Критерии оценки работы:<br/>
        <ul>
            <li>
                не выполнялась - работа не выполнялась
            </li>
            <li>
                работа выполнена неудовлетворительно, с многочисленными замеаниями
            </li>
            <li>
                работа выполнена удовлетворительно, имеются отдельные существенные замечания
            </li>
            <li>
                работа выполнена хорошо, с несущественными замеаниями
            </li>
            <li>
                работа выполнена отлично, без замечаний
            </li>
        </ul>

        <br/>
        <p>
            <b>О 3 Поектирование и разработка основных образовательных программ, программ дополнительного образования</b>
        </p>


        <!-- ============================================================== -->

        <?php
        if ($methodist || $specUVP || $eng || $masterPO) {
            show_process('o3_1', 'Имеются раразботанные УМК, рабочие программы дисциплин.');
        }
        if ($st_lab || $lab || $methodist || $specUVP) {
            show_process('o3_2', 'Имеются учебно-методические и програмные материалы пл ООП: учебный план, рабочие учебные программы, УМК и т.п.');
        }

        ?>

        <p>
            <b>О 4 Реализация основных образовательных программ, программ дополнительного образования</b>
        </p>

        <?php
        if ($doc || $sec) {
            show_process('o4_1', 'Оформление документов, вновь поступивших студентов (приказы, зачетные книжки, студенческие билеты, дела');
        }
        if ($doc || $sec) {
            show_process('o4_2', 'Ведение документации по движению контингента студентов (приказы, распоряжения)');
        }
        if ($doc || $sec) {
            show_process('o4_3', 'Оформление сессонных документов (расписание сессий, ведомости, экзаменацонные листы)');
        }
        if ($doc || $sec || $methodist || $st_lab || $lab) {
            show_process('o4_4', 'Составление учебных расписаний и оперативная их коррекция (расписание учебных занятий)');
        }

        if ($st_lab || $lab || $methodist || $eng || $tech) {
            show_process('o4_5', 'Обслуживание технического оборудования, в том числе операционных систем и программ');
        }
        ?>


        <br/>
        <button id="add_btn" type="button" class="btn  btn-success">Добавить</button>
        <button type="submit" class="hidden" id="submit_btn">submit</button>
    </fieldset>
</form>

<script>
    $(document).ready(function() {
        $("#add_btn").click(function() {
            // если форма не валидна - выходим
            var form = $('#form')[0];
            if (!form.checkValidity()) {
                $('#form').find('#submit_btn').click();
                return;
            }
            if (hand_made_validation() != 0) {
                return;
            }
            $("#form").submit();
        });
    });
</script>