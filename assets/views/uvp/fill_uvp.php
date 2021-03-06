<?php
function show_process($code, $text) {
            echo $text.'
        <input type="hidden" name="'.$code.'_name" value="'.$text.'"/>
        <br/>
        <select name="'.$code.'_points" required style="width:260px;">
            <option value="0.0">Работа не выполнялась</option>
            <option value="0.5">Выполнена неудовлетворительно</option>
            <option value="1.0">Выполнена удовлетворительно</option>
            <option value="1.5">Выполнена хорошо</option>
            <option value="2.0">Выполнена отлично</option>
        </select>
        <br/>';
        }
?>

<form method="POST" id="form" name="anketa" action="/uvp/save_stage">
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
        if ($st_lab || $lab || $methodist || $eng || $tech) {
            show_process('o4_6', 'Выполнение текущих и профилактических работ по содержанию оборудования, используемого в образовательном процессе (журнал учета работ)');
        }
        if ($st_lab || $lab || $methodist || $eng || $tech || $masterPO) {
            show_process('o4_7', 'Устранение неисправностей своими силами или передача технических и иных средств в специализированные ремонтные центры (журнал учета работ)');
        }
        if ($st_lab || $lab || $methodist || $eng || $tech || $masterPO || $specUVP) {
            show_process('o4_8', 'Участие в подготовке учебных аудиторий и лабораторий к проведению учебных занятий (заявки, техническое задание, журнал учета)');
        }
        ?>

        <p>
            <b>О 5 Внеаудиторная профессионализируюшая деятельность</b>
        </p>

        <?php
        if ($st_lab || $lab || $methodist || $specUVP) {
            show_process('o5_1', 'Оказание помощи студентам и преподавателям в техническом оформлении материалов (своевременность и точность оформления материалов)');
        }
        ?>

        <p>
            <b>О 6 Повышение квалификации и профессиональная переподготовка</b>
        </p>

        <?php
        if ($st_lab || $lab || $methodist) {
            show_process('o6_1', 'Техническое оформление программ и иных учебно-методических материалов (своевременность и точность оформления материалов) ');
        }
        ?>

        <p>
            <b>О 7 Научная деятельность</b>
        </p>


        <?php
        if ($st_lab || $lab || $methodist || $specUVP) {
            show_process('o7_1', 'Информирование ППС о семинарах, научных конференциях и др. (Объявление, информационный лист)');
        }
        if ($st_lab || $lab || $methodist || $specUVP) {
            show_process('o7_2', 'Техническое оформление научных заявок, документации, связанной с научной работой ППС (заявки, отзывы, экспертные заключения, справки, рецензии и т.п.) ');
        }
        ?>

        <p>
            <b>О 8 Закупки</b>
        </p>


        <?php
        if ($st_lab || $lab || $methodist || $eng || $tech) {
            show_process('o8_1', 'Оформление заявок на приобретение необходимого технического оборудования и на списание устаревшего оборудования (заявки, акты)');
        }
        if ($st_lab || $lab || $methodist ||  $specUVP) {
            show_process('o8_2', 'Техническое оформление заявок на учебно-методическую и научную литературу, периодические издания (заявки)');
        }
        if ($st_lab || $lab || $methodist || $doc || $sec) {
            show_process('o8_3', 'Техническое оформление заявок на канцтовары и расходные материалы (заявки)');
        }
        ?>

        <p>
            <b>В 1 Управление персоналом</b>
        </p>


        <?php
        if ($specUVP || $methodist || $doc || $sec) {
            show_process('b1_1', 'Информирование студентов и ППС об изменениях в графике учебных занятий (объявления, график, расписание учебных занятий)');
        }
        if ($st_lab || $lab || $methodist) {
            show_process('b1_2', 'Информирование ППС о заседаниях, семинарах и др. (объявления, планы мероприятий)');
        }
        if ($doc || $sec) {
            show_process('b1_3', 'Учет посещаемости занятий студентами (журнал)');
        }
        if ($st_lab || $methodist || $eng || $tech || $masterPO) {
            show_process('b1_4', 'Обучение персонала подразделений работе с техническими средствами (инструкция, журнал)');
        }
        if ($st_lab || $methodist || $doc || $sec) {
            show_process('b1_5', 'Получение, хранение и доведение до сотрудников приказов, распоряжений, касающихся различных аспектов деятельности вуза (распоряжения, приказы, журнал)');
        }
        if ($st_lab || $lab || $methodist || $doc || $sec) {
            show_process('b1_6', 'Техническое оформление документации в соответствии с номенклатурой дел (документация подразделения в соответствии с номенклатурой дел ПГПУ)');
        }
        if ($st_lab || $lab || $methodist || $doc || $sec) {
            show_process('b1_7', 'Техническое оформление материалов к конкурсным процедурам (материалы к конкурсным процедурам)');
        }
        ?>

        <p>
            <b>В 2 Библиотечное и информационное обслуживание</b>
        </p>


        <?php
        if ($st_lab || $lab || $methodist || $doc || $sec || $eng || $tech || $specUVP) {
            show_process('b2_1', 'Информирование студентов и ППС об имеющихся информационных ресурсах (объявления, каталоги)');
        }
        if ($st_lab || $lab || $methodist || $doc || $sec || $eng) {
            show_process('b2_2', 'Обеспечение хранения документации в соответствии с номенклатурой дел ОУ и подготовка к передаче в архив (документация в соответствии с номенклатурой дел подразделения, акты о передаче дел в архив, акты об уничтожении)');
        }
        if ($doc || $sec) {
            show_process('b2_3', 'Регистрация и выдача справок по заявкам внутренних и внешних потребителей (журнал регистрации справок)');
        }
        if ($st_lab || $lab || $methodist || $specUVP) {
            show_process('b2_4', 'Техническое оформление материалов для сайта подразделения (материалы)');
        }
        if ($st_lab || $lab || $methodist || $eng || $tech || $masterPO) {
            show_process('b2_5', 'Обеспечение выдачи и возврата учебно-методических материалов студентам и ППС (каталоги материалов, форма учета выдачи и возврата)');
        }
        ?>

        <p>
            <b>В 3 Управление инфраструктурой и производственной средой: образовательная среда</b>
        </p>


        <?php
        if ($st_lab || $methodist || $doc || $sec || $eng || $tech || $masterPO) {
            show_process('b3_1', 'Учет и хранение материально-технического оборудования (материально-техническое оборудование, журнал заявок)');
        }
        if ($st_lab || $lab || $methodist || $tech || $specUVP) {
            show_process('b3_2', 'Учет и хранение информационно-методических материалов (информационно-методические материалы (электронный, бумажный формат), каталоги)');
        }
        ?>

        <p>
            <b>В 4 Редакционно-издательская деятельность</b>
        </p>


        <?php
        if ($st_lab || $lab || $methodist || $specUVP) {
            show_process('b4_1', 'Подготовка к опубликованию учебно-методических материалов (учебно-методические материалы, техническое задание)');
        }
        if ($st_lab || $lab || $methodist || $specUVP) {
            show_process('b4_2', 'Подготовка к опубликованию научных и научно-методических материалов, включенных в план издательской деятельности кафедры (научные и научно-методические материалы, техническое задание)');
        }
        ?>

        <p>
            <b>С 1 Планирование СМК</b>
        </p>


        <?php
        if ($st_lab || $lab || $methodist || $doc || $sec || $specUVP || $eng) {
            show_process('с1_1', 'Организация внутреннего и внешнего информационного обмена (оперативность и точность реагирования на информационные запросы)');
        }
        ?>

        <p>
            <b>С 2 Измерение, анализ и улучшения</b>
        </p>


        <?php
        if ($st_lab || $lab || $doc || $sec) {
            show_process('с2_1', 'Оформление графиков мониторинговых процедур (графики, объявления, расписание мониторинговых процедур)');
        }
        if ($st_lab || $lab || $methodist || $eng || $tech) {
            show_process('с2_2', 'Оформление банков данных контрольно-измерительных материалов (банки данных КИМов (электронный, бумажный формат))');
        }
        if ($st_lab || $lab || $methodist || $specUVP || $eng || $doc || $sec) {
            show_process('с2_3', 'Оформление банков данных, агрегирование результатов мониторинговых процедур (банки данных результатов мониторинговых процедур)');
        }
        if ($st_lab || $lab || $methodist || $specUVP || $eng || $doc || $sec) {
            show_process('с2_4', 'Оформление банка данных по итоговому, промежуточному и др. видам контроля, а также по результатам практики (банки данных результатов итогового, промежуточного, текущего и др. видов контроля, отчеты преподавателей и студентов)');
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