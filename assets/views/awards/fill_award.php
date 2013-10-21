<?php
function first_stage() {
    echo '
<fieldset>
    <label>Научная деятельность</label>
    Научные школы:
    <input type="hidden" name="o7_1_name" value="Научные школы"/>
    <br/><input type="checkbox" name="o7_1">1 и более</input>

    <label>Индекс научной эффективности подразделения</label>
    число аспирантов, защитившихся в отчетный период
    <input type="hidden" name="o7_2_name" value="число аспирантов, защитившихся в отчетный период"/>
    <br/><input type="number" name="o7_2" value="0" min="0" max="10000" required/>
    <br/><br/>
    число докторантов, защитившихся в отчетный период
     <input type="hidden" name="o7_2a_name" value="число докторантов, защитившихся в отчетный период"/>
    <br/><input type="number" name="o7_2a" value="0" min="0" max="10000" required/>
    <br/><br/>
    руководство грантами РФФИ, РГНФ, федеральных  целевых Программ, Программы стратегического развития вуза
    <input type="hidden" name="o7_3_name" value="руководство грантами РФФИ, РГНФ, федеральных  целевых Программ, Программы стратегического развития вуза"/>
    <br/><input type="number" name="o7_3" value="0" min="0" max="10000" required/>
    <br/><br/>
    организация конференций любого уровня
    <input type="hidden" name="o7_4_name" value="организация конференций любого уровня"/>
    <br/><input type="number" name="o7_4" value="0" min="0" max="10000" required/>
    <br/><br/>
    выступления сотрудников с докладами на международных и всероссийских конференциях
    <input type="hidden" name="o7_5_name" value="выступления сотрудников с докладами на международных и всероссийских конференциях"/>
    <br/><input type="number" name="o7_5" value="0" min="0" max="10000" required/>
    <br/><br/>
    количество монографий с  ISBN, или разделов в коллективных монографиях
    <table>
        <tr>
            <td>
                изданий в РФ
                <input type="hidden" name="o7_6_name" value="количество монографий с  ISBN, или разделов в коллективных монографиях, изданий в РФ"/>
            </td>
            <td style="padding-left: 10px;">
                изданий за рубежом
                <input type="hidden" name="o7_6a_name" value="количество монографий с  ISBN, или разделов в коллективных монографиях, изданий за рубежом"/>
            </td>
        </tr>
        <tr>
            <td>
                <input type="number" name="o7_6" value="0" min="0" max="10000" required/>
            </td>
            <td style="padding-left: 10px;">
                <input type="number" name="o7_6a" value="0" min="0" max="10000" required/>
            </td>
        </tr>
    </table>
    <br/><br/>
    учебников с грифом МОН РФ, Рособразования, УМО
    <input type="hidden" name="o7_6b_name" value="учебников с грифом МОН РФ, Рособразования, УМО"/>
    <br/><input type="number" name="o7_6b" value="0" min="0" max="10000" required/>
    <br/><br/>
    количество статей в рецензируемых (ВАК) изданиях
    <input type="hidden" name="o7_7_name" value="количество статей в рецензируемых (ВАК) изданиях"/>
    <br/><input type="number" name="o7_7" value="0" min="0" max="10000" required/>
    <br/><br/>
    количество статей в зарубежных индексируемых изданиях
    <input type="hidden" name="o7_8_name" value="количество статей в зарубежных индексируемых изданиях"/>
    <br/><input type="number" name="o7_8" value="0" min="0" max="10000" required/>
    <br/><br/>
    количество статей в других изданиях
    <input type="hidden" name="o7_9_name" value="количество статей в других изданиях"/>
    <br/><input type="number" name="o7_9" value="0" min="0" max="10000" required/>
</fieldset>
';
}


function second_stage() {
    echo '<fieldset>
    <label>Проектирование и разработка образовательных программ</label>
    Разработка и реализация основных образовательных программ (количество)
    <input type="hidden" name="o2_1_name" value="Разработка и реализация основных образовательных программ (количество)"/>
    <br/><input type="number" name="o2_1" value="0" min="0"  max="2000" required/>
    <br/><br/>

    Разработка и  реализация образовательных программ повышения квалификации (количество)
    <input type="hidden" name="o2_2_name" value="Разработка и  реализация образовательных программ повышения квалификации"/>
    <br/><input type="number" name="o2_2" value="0" min="0"  max="2000" required/>
    <br/><br/>

    <label>Реализация образовательных программ</label>
    Результаты ИГА
    <input type="hidden" name="o3_1_name" value="Результаты ИГА"/>
    <br/>
    <select name="o3_1" required>
        <option value="1.5">100%</option>
        <option value="1.0">95%-99%</option>
        <option value="0.5">85%-94%</option>
        <option value="0.0">Менее 85%</option>
    </select>
    <br/><br/>

    Сохранность контингента
    <input type="hidden" name="o3_2_name" value="Сохранность контингента"/>
    <br/>
    <select name="o3_2" required>
        <option value="2.0">90% и более</option>
        <option value="1.5">80%-89%</option>
        <option value="1.0">70%-79%</option>
        <option value="0.0">Менее 70%</option>
    </select>
    <br/><br/>

    Качество знаний студентов
    (успевающих на «хорошо» и
    «отлично») по факультету (по
    итогам сессии) за предыдущий год
    <input type="hidden" name="o3_3_name" value="Качество знаний студентов по факультету за предыдущий год"/>
    <br/>
    <select name="o3_3" required>
        <option value="2.0">50% и более</option>
        <option value="1.5">40%-49%</option>
        <option value="1.0">30%-39%</option>
        <option value="0.0">Менее 30%</option>
    </select>
    <br/><br/>
</fieldset>';
}

function third_stage() {
    echo '<fieldset>
        <label>Маркетинг</label>

        Трудоустройство выпускников
        по специальности с
        предоставлением
        подтверждающих трудоустройство
        документов (после  оформления
        выпускников на работу
        <input type="hidden" name="o1_1_name" value="Трудоустройство выпускников по специальности"/>
        <br/>
        <select name="o1_1" required>
            <option value="2.0">60% и более</option>
            <option value="1.5">От 45% до 59%</option>
            <option value="1.0">От 40% до 44%</option>
            <option value="0.5">Менее 40%</option>
        </select>
        <br/><br/>


        Число договоров, заключенных с
        работодателями  на целевую
        подготовку  специалистов и (или)
        на трудоустройство выпускников
        <input type="hidden" name="o1_2_name" value="Число договоров, заключенных с работодателями  на целевую подготовку  специалистов"/>
        <br/>
        <select name="o1_2" required>
            <option value="2.0">Более 3%</option>
            <option value="1.5">До 2%</option>
            <option value="1.0">До 1%</option>
            <option value="0.5">Менее 1%</option>
            <option value="0.0">0</option>
        </select>
        <br/><br/>

        Доля выпускников, состоящих на учете в службах занятости
        <input type="hidden" name="o1_3_name" value="Доля выпускников, состоящих на учете в службах занятости"/>
        <br/>
        <select name="o1_3" required>
            <option value="2.0">0%</option>
            <option value="1.5">1-5%</option>
            <option value="1.0">5-10%</option>
            <option value="0.5">10%-15%</option>
            <option value="0.0">Более 15%</option>
        </select>
        <br/><br/>

        <label>Реализация программ повышения квалификации</label>
        Объем привлеченных  в университет средств за счет реализации программ повышения квалификации
        <input type="hidden" name="o4_1_name" value="Объем привлеченных  в университет средств за счет реализации программ повышения квалификации"/>
        <br/>
        <select name="o4_1" required>
            <option value="2.0">Свыше 100 тыс. руб.</option>
            <option value="1.5">От 100 до 50 тыс. руб.</option>
            <option value="1.0">Менее  50 тыс. руб.</option>
            <option value="0.0">0</option>
        </select>
        <br/><br/>

        <label>Прием студентов</label>
        <input type="hidden" name="o5_1_name" value="Реализация  утвержденной  в вузе программы  деятельности факультета  по привлечению абитуриентов"/>
        <input type="checkbox" name="o5_1">Реализация  утвержденной  в вузе
        программы  деятельности
        факультета  по привлечению
        абитуриентов</input>
        <br/><br/>

        <label>Внеучебная профессионализирующая деятельность</label>
        Оценка студентами качества внеучебной
        профессионализирующей
        деятельности (анкетирование)
        Анкетный балл:
        <input type="hidden" name="o6_1_name" value="Оценка студентами качества внеучебной профессионализирующей деятельности"/>
        <br/>
        <select name="o6_1" required>
            <option value="1.0">Отлично</option>
            <option value="0.75">Хорошо</option>
            <option value="0.5">Удовлетворительно</option>
            <option value="0.0">Неудовлетворительно</option>
        </select>
        <br/><br/>

        <input type="hidden" name="o6_2_name" value="Реализация проектов в рамках внеучебной профессионализирующей деятельности, отмеченнаягрантами различного уровня"/>
        <input type="checkbox" name="o6_2">Реализация проектов в рамках внеучебной
        профессионализирующей деятельности,
        отмеченнаягрантами различного уровня</input>
        <br/><br/>

        <label>Управление персоналом</label>
        Укомплектованность штатов
        сотрудниками, для которых
        ПГГПУ является основным местом
        работы (в долях ставок)
        <input type="hidden" name="b1_2_name" value="Укомплектованность штатов сотрудниками, для которых ПГГПУ является основным местом работы"/>
        <br/>
        <select name="b1_2" required>
            <option value="1.0">От 75% и более</option>
            <option value="0.5">74%-50%</option>
            <option value="0.0">Менее 50%</option>
        </select>
        <br/><br/>

        <input type="hidden" name="b1_1a_name" value="Привлечение к реализации образовательного
        процесса ведущих специалистов по отрасли"/>
        <input type="checkbox" name="b1_1a">Привлечение к реализации образовательного
        процесса ведущих специалистов по отрасли</input>
        <br/><br/>


        Остепененность ППС  (в долях ставок)
        <input type="hidden" name="b1_1_name" value="Остепененность ППС  (в долях ставок)"/>
        <br/>
        <select name="b1_1" required style="width:350px;">
            <option value="1.0">50% (общая)в том числе  10% (докторов наук)</option>
            <option value="0.5">49%-45% (общая)  в том числе  8% (докторов наук)</option>
            <option value="0.0">Менее 45% (общая)  в том  числе менее 8% (докторов наук)</option>
        </select>
        <br/>
    </fieldset>';
}
?>

<form method="POST" id="form" action="/award/save_stage">
    <fieldset>
        <input type="hidden" name="stage_id" value="<?php echo $stage->id; ?>"/>
        <input type="hidden" name="year" value="<?php echo $year; ?>"/>
        <input type="hidden" name="faculty" value="<?php echo $faculty; ?>"/>

        <legend>Добавить расчет баллов стимулирующих выплат </legend>
        <span class="subtitle">за период "<?php echo $stage->name ?>" в <?php echo $year?>г.</span>
        <?php
            switch ($stage->id) {
                case 1:
                    first_stage();
                    break;
                case 2:
                    second_stage();
                    break;
                case 3:
                    third_stage();
                    break;
                default:
                    $error = "Не верно переданы параметры этапа";
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