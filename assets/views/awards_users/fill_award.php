<?php
function first_stage() {
    echo '
<fieldset>
    <label>Научная деятельность</label>
    <label>Индекс научной эффективности преподавателя</label>
    число аспирантов/докторантов, защитившихся в отчетный период
    <br/><input type="number" name="o7_2" value="0" required/>
    <br/><br/>
    руководство грантами РФФИ, РГНФ, федеральных  целевых Программ, Программы стратегического развития вуза
    <br/><input type="number" name="o7_3" value="0" required/>
    <br/><br/>
    организация конференций любого уровня
    <br/><input type="number" name="o7_4" value="0" required/>
    <br/><br/>
    выступления сотрудников с докладами на международных и всероссийских конференциях
    <br/><input type="number" name="o7_5" value="0" required/>
    <br/><br/>
    количество монографий с  ISBN, или разделов в коллективных монографиях,  учебников с грифом МОН РФ, Рособразования, УМО
    <br/><input type="number" name="o7_6" value="0" required/>
    <br/><br/>
    количество статей в рецензируемых (ВАК) изданиях
    <br/><input type="number" name="o7_7" value="0" required/>
    <br/><br/>
    в зарубежных индексируемых изданиях
    <br/><input type="number" name="o7_8" value="0" required/>
    <br/><br/>
    количество статей в других изданиях
    <br/><input type="number" name="o7_9" value="0" required/>
</fieldset>
';
}


function second_stage() {
    echo '<fieldset class="stage2">
    <h4>Проектирование и разработка образовательных программ</h4>
    <label>Организационно-педагогическая
    оснащенность образовательного
    процесса</label>

    <input type="checkbox" name="o2_1" >100% наличия на кафедре
    ежегодно обновляемых УМК по
    преподаваемым дисциплинам</input>
    <br/><br/>


    <input type="checkbox" name="o2_2">наличие БТЗ  на сервере ВУЗа по преподаваемым дисциплинам</input>
    <br/><br/>

    <input type="checkbox" name="o2_3">наличие  на кафедре  авторских
    мультимедийных материалов по
    дисциплинам</input>
    <br/><br/>

    наличие  на кафедре  авторских
    учебно-методических пособий по
    дисциплине
    <br/>
     <select name="o2_4" required>
        <option value="0.4">с грифом</option>
        <option value="0.2">без грифа</option>
    </select>
    <br/><br/>


    <input type="checkbox" name="o2_5">Наличие  на кафедре  цифровых
    образовательных ресурсов,
    используемых в практической
    деятельности и
    зарегистрированных в
    установленном порядке в
    Информрегистре. От 1 и более</input>
    <br/><br/>

    <h4>Реализация образовательных программ</h4>
    <label>Процент  обучающихся,
    отчисленных  до окончания срока
    обучения  из-за неусвоения
    читаемого преподавателем курса</label>
    <select name="o3_1" required>
        <option value="2.0">Менее 4%</option>
        <option value="1.0">от 4% до 10%</option>
        <option value="0.0">Более 10%</option>
    </select>
    <br/><br/>

    <label>Качество знаний студентов</label>
    Количество успевающих на
    «хорошо» и «отлично» по
    преподаваемой дисциплине(ам). Дисциплина завершается экзаменом
    <br/>
    <select name="o3_2" required>
        <option value="2.0">50% и выше</option>
        <option value="1.0">40%-49%</option>
        <option value="0.5">30%-39%</option>
        <option value="0.0">Менее 30%</option>
    </select>
    <br/><br/>

    Количество успевающих на
    «хорошо» и «отлично» по
    преподаваемой дисциплине(ам). Дисциплина завершается зачетом
    <br/>
    <select name="o3_3" required>
        <option value="2.0">от 91% до 100% аттестованы</option>
        <option value="1.5">от 81% до 90% аттестованы</option>
        <option value="1.0">от 71% до 80% аттестованы</option>
        <option value="0.0">менее 70% аттестованы</option>
    </select>
    <br/><br/>

    <label>Использование  балльно-рейтинговой системы оценивания в
    учебном процессе</label>
    <select name="o3_4" required>
        <option value="0.5">фрагментарное использование</option>
        <option value="1.5">системное использование</option>
    </select>
    <br/><br/>

    <label>Использование современных
    технологий преподавания</label>
    <select name="o3_5" required>
        <option value="0.5">фрагментарное использование</option>
        <option value="1.5">системное применение</option>
    </select>
</fieldset>';
}

function third_stage() {
    echo '<fieldset>
        <h4>Маркетинг</h4>

        <label>Признание профессиональным
        сообществом  (экспертная
        деятельность, курирование
        экспериментальных площадок,
        руководство проектной
        деятельностью, участие в работе
        научных советов федерального,
        регионального и городского
        уровней)</label>
        <input type="checkbox" name="o1_1">признанный преподаватель</input>
        <br/><br/>

        <h4>Реализация
        программ
        повышения
        квалификации</h4>

        <label>Участие в реализации программ
        повышения квалификации</label>
        <select name="o4_1" required>
            <option value="2.0">более 3 программ</option>
            <option value="1.0">2-3 программы</option>
            <option value="0.5">1 программыа</option>
        </select>
        <br/><br/>

        <h4>Управление персоналом</h4>
        <label>Результаты анкетирования
        «Преподаватель глазами студента»</label>
        <select name="b1_1" required>
            <option value="2.0">Анкетный балл от 4 до 5</option>
            <option value="1.5">Анкетный балл от 3 до 4</option>
            <option value="1.0">Анкетный балл от 2 до 3</option>
            <option value="0.0">Менее 2</option>
        </select>
        <br/><br/>

        <h4>Внеучебная
        профессионали
        зирующая
        деятельность</h4>

        <label>Подготовка победителей  научных и
        творческих конкурсов, олимпиад,
        смотров, соревнований</label>
        <select name="o6_1" required style="width:320px;">
            <option value="0.7">федерального и международного уровней</option>
            <option value="0.3">регионального уровня</option>
        </select>
        <br/><br/>

        <label>Наличие студенческих публикаций,
        выступлений студентов на научных
        конференциях</label>
        <select name="o6_2" required style="width:320px;">
            <option value="0.7">федерального и международного уровней</option>
            <option value="0.3">регионального уровня</option>
        </select>
    </fieldset>';
}
?>

<form method="POST" id="form" action="/awarduser/save_stage">
    <fieldset>
        <input type="hidden" name="stage_id" value="<?php echo $stage->id; ?>"/>
        <input type="hidden" name="year" value="<?php echo $year; ?>"/>
        <input type="hidden" name="user" value="<?php echo $user; ?>"/>

        <legend>Добавить расчет стимулирующих выплат для пользователя</legend>
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