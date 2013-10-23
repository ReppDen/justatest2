<?php
function first_stage()
{
    echo '
<fieldset>
    <label>Научная деятельность</label>
    <label>Индекс научной эффективности преподавателя</label>
    число аспирантов, защитившихся в отчетный период
    <input type="hidden" name="o7_2_name" value="число аспирантов, защитившихся в отчетный период"/>
    <br/><input type="number" name="o7_2" value="0" required/>
    <br/><br/>
    число докторантов, защитившихся в отчетный период
    <input type="hidden" name="o7_1_name" value="число докторантов, защитившихся в отчетный период"/>
    <br/><input type="number" name="o7_1" value="0" required/>
    <br/><br/>
    руководство грантами РФФИ, РГНФ, федеральных  целевых Программ, Программы стратегического развития вуза
    <input type="hidden" name="o7_3_name" value="руководство грантами РФФИ, РГНФ, федеральных  целевых Программ, Программы стратегического развития вуза"/>
    <br/><input type="number" name="o7_3" value="0" required/>
    <br/><br/>
    организация конференций любого уровня
    <input type="hidden" name="o7_4_name" value="организация конференций любого уровня"/>
    <br/><input type="number" name="o7_4" value="0" required/>
    <br/><br/>
    выступления сотрудников с докладами на международных и всероссийских конференциях
    <input type="hidden" name="o7_5_name" value="выступления сотрудников с докладами на международных и всероссийских конференциях"/>
    <br/><input type="number" name="o7_5" value="0" required/>
    <br/><br/>
    количество монографий с  ISBN, или разделов в коллективных монографиях,  учебников с грифом МОН РФ, Рособразования, УМО
    <input type="hidden" name="o7_6_name" value="количество монографий с  ISBN, или разделов в коллективных монографиях,  учебников с грифом МОН РФ, Рособразования, УМО"/>
    <br/><input type="number" name="o7_6" value="0" required/>
    <br/><br/>
    количество статей в рецензируемых (ВАК) изданиях
    <input type="hidden" name="o7_7_name" value="количество статей в рецензируемых (ВАК) изданиях"/>
    <br/><input type="number" name="o7_7" value="0" required/>
    <br/><br/>
    в зарубежных индексируемых изданиях
    <input type="hidden" name="o7_8_name" value="в зарубежных индексируемых изданиях"/>
    <br/><input type="number" name="o7_8" value="0" required/>
    <br/><br/>
    количество статей в других изданиях
    <input type="hidden" name="o7_9_name" value="количество статей в других изданиях"/>
    <br/><input type="number" name="o7_9" value="0" required/>
</fieldset>
';
}


function second_stage()
{
    echo '<fieldset class="stage2">
    <h4>Проектирование и разработка образовательных программ</h4>
    <label>Организационно-педагогическая
    оснащенность образовательного
    процесса</label>

    <input type="hidden" name="o2_1_name" value="100% наличия на кафедре ежегодно обновляемых УМК по преподаваемым дисциплинам"/>
    <input type="checkbox" name="o2_1" >100% наличия на кафедре
    ежегодно обновляемых УМК по
    преподаваемым дисциплинам</input>
    <br/><br/>


    количество БТЗ  на сервере ВУЗа по преподаваемым дисциплинам
    <input type="hidden" name="o2_2_name" value="количество БТЗ  на сервере ВУЗа по преподаваемым дисциплинам"/>
    <br/>
    <input type="number" name="o2_2" required="true" value="0" min="0" max="10000"/>
    <br/><br/>


    количество разработанных тестовых заданий
    <input type="hidden" name="o2_2a_name" value="количество разработанных тестовых заданий"/>
    <br/>
    <select name="o2_2a" required>
        <option value="0.0">Отсутствие тестовых заданий</option>
        <option value="0.6">До 200 тестовых заданий</option>
        <option value="1.2">От 201 до 400 тестовых заданий</option>
        <option value="1.8">Более 400 тестовых заданий</option>
    </select>
    <br/><br/>

    наличие  на кафедре  авторских
    мультимедийных материалов по
    дисциплинам
    <input type="hidden" name="o2_3_name" value="наличие  на кафедре  авторских мультимедийных материалов по дисциплинам"/>
    <br/>
    <select name="o2_3" required>
        <option value="0.6">100% читаемых</option>
        <option value="0.4">от 75% читаемых</option>
        <option value="0.2">от 50% читаемых</option>
        <option value="0.0">менее 50% читаемых</option>
    </select>
    <br/><br/>

    наличие  на кафедре  авторских
    учебно-методических пособий по
    дисциплине
    <input type="hidden" name="o2_4_name" value="наличие  на кафедре  авторских учебно-методических пособий по дисциплине"/>
    <br/>
     <select name="o2_4" required>
        <option value="1.0">с грифом</option>
        <option value="0.3">без грифа</option>
        <option value="0.0">нет пособий</option>
    </select>
    <br/><br/>

    Участие в разработке и улучшении ООП,
    реализуемых в подразделении
    <input type="hidden" name="o2_4a_name" value="Участие в разработке и улучшении ООП, реализуемых в подразделении"/>
    <br/>
    <input type="number" name="o2_4a" required="true" value="0" min="0" max="10000"/>
    <br/><br/>

    Наличие  на кафедре  цифровых
    образовательных ресурсов,
    используемых в практической
    деятельности и
    зарегистрированных в
    установленном порядке в
    Информрегистре. От 1 и более<br/>
    <input type="hidden" name="o2_5_name" value="Наличие  на кафедре  цифровых
    образовательных ресурсов,
    используемых в практической
    деятельности и
    зарегистрированных в
    установленном порядке в
    Информрегистре"/>
    <input type="number" name="o2_5" required="true" value="0" min="0" max="10000"/>
    <br/><br/>

    <h4>Реализация образовательных программ</h4>
    <label>Процент  обучающихся,
    отчисленных  до окончания срока
    обучения  из-за неусвоения
    читаемого преподавателем курса</label>
    <input type="hidden" name="o3_1_name" value="Процент  обучающихся,
    отчисленных  до окончания срока
    обучения  из-за неусвоения
    читаемого преподавателем курса"/>
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
    <input type="hidden" name="o3_2_name" value="Количество успевающих на
    «хорошо» и «отлично» по
    преподаваемой дисциплине(ам). Дисциплина завершается экзаменом"/>
    <br/>
    <select name="o3_2" required>
        <option value="2.0">50% и выше</option>
        <option value="1.0">40%-49%</option>
        <option value="0.5">30%-39%</option>
        <option value="0.0">Менее 30%</option>
        <option value="0.0">у преподавателя нет экзаменов</option>
    </select>
    <br/><br/>

    Количество успевающих на
    «хорошо» и «отлично» по
    преподаваемой дисциплине(ам). Дисциплина завершается зачетом
    <input type="hidden" name="o3_3_name" value="Количество успевающих на
    «хорошо» и «отлично» по
    преподаваемой дисциплине(ам). Дисциплина завершается зачетом"/>
    <br/>
    <select name="o3_3" required>
        <option value="2.0">от 91% до 100% аттестованы</option>
        <option value="1.5">от 81% до 90% аттестованы</option>
        <option value="1.0">от 71% до 80% аттестованы</option>
        <option value="0.0">менее 70% аттестованы</option>
        <option value="0.0">у преподавателя нет зачетов</option>
    </select>
    <br/><br/>

    <label>Использование  балльно-рейтинговой системы оценивания в
    учебном процессе</label>
    <input type="hidden" name="o3_4_name" value="Использование  балльно-рейтинговой системы оценивания в
    учебном процессе"/>
    <select name="o3_4" required>
        <option value="0.5">фрагментарное использование</option>
        <option value="1.5">системное использование</option>
        <option value="0.0">не используется</option>
    </select>
    <br/><br/>

    <label>Использование современных
    технологий преподавания</label>
    <input type="hidden" name="o3_5_name" value="Использование современных
    технологий преподавания"/>
    <select name="o3_5" required>
        <option value="0.5">фрагментарное использование</option>
        <option value="1.0">системное применение</option>
        <option value="0.0">не используется</option>
    </select>
    <br/><br/>


    <label>Использование в учебном
    процессе тестовых технологий</label>
    <input type="hidden" name="o3_6_name" value="Использование в учебном
    процессе тестовых технологий"/>
    <select name="o3_6" required>
        <option value="0.6">Более 3 сеансов</option>
        <option value="0.4">От 1 до 2</option>
        <option value="0.0">Не используется</option>
    </select>
</fieldset>';
}

function third_stage()
{
    echo '<fieldset>
        <h4>Маркетинг</h4>
        <label>Участие в реализации мероприятий по
        содействию трудоустройству выпускников</label>
        <input type="hidden" name="o1_1_name" value="Участие в реализации мероприятий по
        содействию трудоустройству выпускников"/>
        <select name="o1_1" required>
            <option value="0.6">Активно участвует</option>
            <option value="0.4">Участвует</option>
            <option value="0.0">не участвует</option>
        </select>
        <br/><br/>

        <h4>Реализация
        программ
        повышения
        квалификации</h4>

        <label>Участие в реализации программ
        повышения квалификации</label>
        <input type="hidden" name="o4_1_name" value="Участие в реализации программ
        повышения квалификаци"/>
        <select name="o4_1" required>
            <option value="2.0">более 3 программ</option>
            <option value="1.0">2-3 программы</option>
            <option value="0.5">1 программа</option>
            <option value="0.0">Не участие</option>
        </select>
        <br/><br/>

        <h4>Управление персоналом</h4>
        <label>Наличие ученой степени/ звания</label>
        <input type="hidden" name="b1_1a_name" value="Наличие ученой степени/звания"/>
        <select name="b1_1a" required>
            <option value="2.0">Доктора наук /профессора</option>
            <option value="1.0">Кандидата наук / доцента</option>
        </select>
        <br/><br/>

        <label>Результаты анкетирования
        «Преподаватель глазами студента»</label>
        <input type="hidden" name="b1_1_name" value="Результаты анкетирования
        «Преподаватель глазами студента»"/>
        <select name="b1_1" required>
            <option value="2.0">Анкетный балл от 4 до 5</option>
            <option value="1.5">Анкетный балл от 3 до 4</option>
            <option value="1.0">Анкетный балл от 2 до 3</option>
            <option value="0.0">Менее 2</option>
        </select>
        <br/><br/>

        <label>Повышение научно-педагогической
        квалификации в отчетный период</label>
        <input type="hidden" name="b1_2_name" value="Повышение научно-педагогической
        квалификации в отчетный период"/>
        <select name="b1_2" required style="width:320px;">
            <option value="2.0">защита докторской диссертации</option>
            <option value="1.0">защита кандидатской диссертации</option>
        </select>
        <br/><br/>


        <label>Признание профессиональным
        сообществом  (экспертная
        деятельность, курирование
        экспериментальных площадок,
        руководство проектной
        деятельностью, участие в работе
        научных советов федерального,
        регионального и городского
        уровней)</label>
        <input type="hidden" name="b1_3_name" value="Признание профессиональным сообществом"/>
        <input type="checkbox" name="b1_3">признанный преподаватель</input>
        <br/><br/>


        <h4>Внеучебная
        профессионали
        зирующая
        деятельность</h4>

        <label>Подготовка победителей  научных и
        творческих конкурсов, олимпиад,
        смотров, соревнований</label>
        <input type="hidden" name="o6_1_name" value="Подготовка победителей  научных и
        творческих конкурсов, олимпиад,
        смотров, соревнований"/>
        <select name="o6_1" required style="width:320px;">
            <option value="0.7">федерального и международного уровней</option>
            <option value="0.3">регионального уровня</option>
        </select>
        <br/><br/>

        <label>Наличие студенческих публикаций,
        выступлений студентов на научных
        конференциях</label>
        <input type="hidden" name="o6_2_name" value="Наличие студенческих публикаций,
        выступлений студентов на научных
        конференциях"/>
        <select name="o6_2" required style="width:320px;">
            <option value="0.7">федерального и международного уровней</option>
            <option value="0.3">регионального уровня</option>
            <option value="0.0">отсутствие</option>
        </select>
        <br/><br/>


        <label>Участие в реализации грантов
        по внеучебной профессионализирующей деятельности</label>
        <input type="hidden" name="o6_3_name" value="Участие в реализации грантов
        по внеучебной профессионализирующей деятельности"/>
        <select name="o6_3" required style="width:320px;">
            <option value="0.6">руководство грантом</option>
            <option value="0.2">участие в реализации грантов</option>
            <option value="0.0">отсутствие</option>
        </select>
        <br/><br/>

        <label>Участие в организации внеучебной
        профессионализирующей деятельности студентов</label>
        <input type="hidden" name="o6_4_name" value="Участие в организации внеучебной
        профессионализирующей деятельности студентов"/>
        <select name="o6_4" required style="width:320px;">
            <option value="0.4">постоянное участие</option>
            <option value="0.2">эпизодическое</option>
            <option value="0.0">отсутствие</option>
        </select>
    </fieldset>';
}

?>

<form method="POST" id="form" action="/oukuser/save_stage">
    <fieldset>
        <input type="hidden" name="stage_id" value="<?php echo $stage->id; ?>"/>
        <input type="hidden" name="year" value="<?php echo $year; ?>"/>
        <input type="hidden" name="user" value="<?php echo $user; ?>"/>

        <legend>Добавить расчет стимулирующих выплат для пользователя</legend>
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