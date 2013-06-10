<?php
function first_stage() {
    echo '
<fieldset>
    <label>Научная деятельность</label>
    Научные школы:
    <br/><input type="checkbox" name="o7_1">1 и более</input>

    <label>Индекс научной эффективности подразделения</label>
    число аспирантов/докторантов, защитившихся в отчетный период
    <br/><input type="number" name="o7_2" value="0" min="0" max="10000" required/>
    <br/><br/>
    руководство грантами РФФИ, РГНФ, федеральных  целевых Программ, Программы стратегического развития вуза
    <br/><input type="number" name="o7_3" value="0" min="0" max="10000" required/>
    <br/><br/>
    организация конференций любого уровня
    <br/><input type="number" name="o7_4" value="0" min="0" max="10000" required/>
    <br/><br/>
    выступления сотрудников с докладами на международных и всероссийских конференциях
    <br/><input type="number" name="o7_5" value="0" min="0" max="10000" required/>
    <br/><br/>
    количество монографий с  ISBN, или разделов в коллективных монографиях,  учебников с грифом МОН РФ, Рособразования, УМО
    <br/><input type="number" name="o7_6" value="0" min="0" max="10000" required/>
    <br/><br/>
    количество статей в рецензируемых (ВАК) изданиях
    <br/><input type="number" name="o7_7" value="0" min="0" max="10000" required/>
    <br/><br/>
    в зарубежных индексируемых изданиях
    <br/><input type="number" name="o7_8" value="0" min="0" max="10000" required/>
    <br/><br/>
    количество статей в других изданиях
    <br/><input type="number" name="o7_9" value="0" min="0" max="10000" required/>
</fieldset>
';
}


function second_stage() {
    echo '<fieldset>
    <label>Проектирование и разработка образовательных программ</label>
    Разработка и реализация основных образовательных программ (количество)
    <br/><input type="number" name="o2_1" value="0" min="0"  max="2000" required/>
    <br/><br/>

    Разработка и  реализация
    образовательных программ
    повышения квалификации (количество)
    <br/><input type="number" name="o2_2" value="0" min="0"  max="2000" required/>
    <br/><br/>

    <label>Реализация образовательных программ</label>
    Результаты ИГА
    <br/>
    <select name="o3_1" required>
        <option value="1.4">100%</option>
        <option value="1.0">95%-99%</option>
        <option value="0.6">85%-94%</option>
        <option value="0.0">Менее 85%</option>
    </select>
    <br/><br/>

    Сохранность контингента
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
        <br/>
        <select name="o1_2" required>
            <option value="2.0">Более 3%</option>
            <option value="1.5">До 2%</option>
            <option value="1.0">До 1%</option>
            <option value="0.5">Менее 1%</option>
            <option value="0.0">0</option>
        </select>
        <br/><br/>

        Доля выпускников, состоящих на
        учете в службах занятости
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
        Объем привлеченных  в
        университет средств за счет
        реализации программ
        повышения квалификации
        <br/>
        <select name="o4_1" required>
            <option value="2.0">Свыше 100 тыс. руб.</option>
            <option value="1.5">От 100 до 50 тыс. руб.</option>
            <option value="1.0">Менее  50 тыс. руб.</option>
            <option value="0.0">0</option>
        </select>
        <br/><br/>

        <label>Прием студентов</label>
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
        <br/>
        <select name="o6_1" required>
            <option value="1.0">Отлично</option>
            <option value="0.75">Хорошо</option>
            <option value="0.5">Удовлетворительно</option>
            <option value="0.0">Неудовлетворительно</option>
        </select>
        <br/><br/>

        <label>Управление персоналом</label>
        Укомплектованность штатов
        сотрудниками, для которых
        ПГГПУ является основным местом
        работы (в долях ставок)
        <br/>
        <select name="b1_2" required>
            <option value="1.0">От 75% и более</option>
            <option value="0.5">74%-50%</option>
            <option value="0.0">Менее 50%</option>
        </select>
        <br/><br/>

        Остепененность ППС  (в долях ставок)
        <br/>
        <select name="b1_1" required style="width:350px;">
            <option value="1.0">60% (общая)в том числе  12% (докторов наук)</option>
            <option value="0.5">59%-50% (общая)  в том числе  10%-11% (докторов наук)</option>
            <option value="0.0">Менее 50% (общая)  в том  числе менее 10% (докторов наук)</option>
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