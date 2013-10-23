<?php
function first_stage()
{
    echo '
<fieldset>
    <label>Научная деятельность</label>
    <label>Оценка научной эффективности кафедры</label>
    <input type="hidden" name="o7_1_name" value="Научные школы 1 и более"/>
    <input type="checkbox" name="o7_1">Научные школы 1 и более</input>
    <br/><br/>
    число аспирантов, защитившихся в отчетный период
    <input type="hidden" name="o7_2_name" value="число аспирантов, защитившихся в отчетный период"/>
    <br/><input type="number" name="o7_2" value="0" min="0" max="10000" required/>
    <br/><br/>
    число докторантов, защитившихся в отчетный период
    <input type="hidden" name="o7_3_name" value="число докторантов, защитившихся в отчетный период"/>
    <br/><input type="number" name="o7_3" value="0" min="0" max="10000" required/>
    <br/><br/>
    наличие грантов РФФИ, РГНФ, федеральных целевых программ, ПСР вуза
    <input type="hidden" name="o7_3a_name" value="наличие грантов РФФИ, РГНФ, федеральных целевых программ, ПСР вуза"/>
    <br/><input type="number" name="o7_3a" value="0" min="0" max="10000" required/>
    <br/><br/>
    организация конференций любого уровня
    <input type="hidden" name="o7_4_name" value="организация конференций любого уровня"/>
    <br/><input type="number" name="o7_4" value="0" min="0" max="10000" required/>
    <br/><br/>
    выступления сотрудников с докладами на международных и всероссийских конференциях
    <input type="hidden" name="o7_5_name" value="выступления сотрудников с докладами на международных и всероссийских конференциях"/>
    <br/><input type="number" name="o7_5" value="0" min="0" max="10000" required/>
    <br/><br/>
    количество монографий с  ISBN, или разделов в коллективных монографиях,  учебников с грифом МОН РФ, Рособразования, УМО
    <table>
        <tr>
            <td>
                изданий в РФ
                <input type="hidden" name="o7_6_name" value="количество монографий с  ISBN, или разделов в коллективных монографиях,  учебников с грифом МОН РФ, Рособразования, УМО в России"/>
            </td>
            <td style="padding-left: 10px;">
                изданий за рубежом
                <input type="hidden" name="o7_6a_name" value="количество монографий с  ISBN, или разделов в коллективных монографиях,  учебников с грифом МОН РФ, Рособразования, УМО за рубежом"/>
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

    количество учебников с грифом МОН РФ, Рособразования,УМО
    <input type="hidden" name="o7_6b_name" value="количество учебников с грифом МОН РФ, Рособразования,УМО"/>
    <br/><input type="number" name="o7_6b" value="0" min="0" max="10000" required/>
    <br/><br/>

    количество статей в рецензируемых (ВАК) изданиях
    <input type="hidden" name="o7_7_name" value="количество статей в рецензируемых (ВАК) изданиях"/>
    <br/><input type="number" name="o7_7" value="0" min="0" max="10000" required/>
    <br/><br/>
    в зарубежных индексируемых изданиях
    <input type="hidden" name="o7_8_name" value="в зарубежных индексируемых изданиях"/>
    <br/><input type="number" name="o7_8" value="0" min="0" max="10000" required/>
    <br/><br/>
    количество статей в других изданиях
    <input type="hidden" name="o7_9_name" value="количество статей в других изданиях"/>
    <br/><input type="number" name="o7_9" value="0" min="0" max="10000" required/>
</fieldset>
';
}

function second_stage()
{
    echo '<fieldset class="stage2">
    <label>Проектирование и разработка образовательных программ (аспирантура)</label>
    Разработка и реализация программ аспирантуры. За каждую реализуемую ООП
    <input type="hidden" name="o2_1_name" value="Разработка и реализация программ аспирантуры. За каждую реализуемую ООП"/>
    <br/><input type="number" name="o2_1" value="0" min="0" max="10000" required/>
    <br/><br/>


    <input type="hidden" name="o2_2_name" value="Разработка и реализация образовательных программ повышения квалификации (ОП.ПК). За каждую реализуемую ОП.ПК"/>
    <input type="checkbox" name="o2_2" >Разработка и реализация образовательных программ повышения квалификации (ОП.ПК). За каждую реализуемую ОП.ПК</input>
    <br/><br/>

    <label>Реализация образовательных программ</label>
    <label>Качество знаний студентов</label>
    Количество успевающих на
    «хорошо» и «отлично» по преподаваемым кафедрой дисциплинам (по итогам сессии)
    <input type="hidden" name="o3_1_name" value="Количество успевающих на
    «хорошо» и «отлично» по преподаваемым кафедрой дисциплинам (по итогам сессии)"/>
    <br/>
    <select name="o3_1" required>
        <option value="2.0">50% и выше</option>
        <option value="1.5">40%-49%</option>
        <option value="1.0">30%-39%</option>
        <option value="0.0">Менее 30%</option>
    </select>
    <br/><br/>
</fieldset>';
}

function third_stage()
{
    echo '<fieldset>
        <h4>Реализация
        программ
        повышения
        квалификации</h4>

        <label>Объем привлеченных в университет средств за счет реализации программ повышения квалификации</label>
        <input type="hidden" name="o4_1_name" value="Объем привлеченных в университет средств за счет реализации программ повышения квалификации"/>
        <select name="o4_1" required>
            <option value="2.0">Свыше 100 тыс.руб</option>
            <option value="1.0">От 100 до 50 тыс.руб</option>
            <option value="0.5">Менее 50 тыс.руб</option>
            <option value="0.0">0</option>
        </select>
        <br/><br/>

        <label>Внеучебная профессионализирующая деятельность</label>
        Оценка студентами качества внеучебной
        профессионализирующей
        деятельности (по результатам анкетирования)
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

        Остепененность ППС  (в долях ставок)
        <input type="hidden" name="b1_1_name" value="Остепененность ППС  (в долях ставок)"/>
        <br/>
        <select name="b1_1" required style="width:350px;">
            <option value="1.0">50% в том числе  10% (докторов наук)</option>
            <option value="0.5">49%-45% (общая)  в том числе  8% (докторов наук)</option>
            <option value="0.0">Менее 45% (общая)  в том  числе менее 8% (докторов наук)</option>
        </select>
        <br/>

    </fieldset>';
}

?>

<form method="POST" id="form" action="/ouk/save_stage">
    <fieldset>
        <input type="hidden" name="stage_id" value="<?php echo $stage->id; ?>"/>
        <input type="hidden" name="year" value="<?php echo $year; ?>"/>
        <input type="hidden" name="faculty" value="<?php echo $faculty; ?>"/>

        <legend>Добавить расчет баллов стимулирующих выплат</legend>
        <span class="subtitle">за период "<?php echo $stage->name ?>" в <?php echo $year ?>г.</span>
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
    $(document).ready(function () {
        $("#add_btn").click(function () {
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
