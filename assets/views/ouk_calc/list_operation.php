<fieldset>
    <legend>Список всех расчетов фондов стимулурующих выплат для ОУК университета</legend>
</fieldset>
<table class="table table_for_years">
    <tr class="title">
        <td class="n">
            №
        </td>
        <td >
            <a href="/oukcalc/list_operation/?sort=stage&dir=<?php echo getDir("stage");?>" class="sorter">Этап<?php echo dirText("stage");?></a>
        </td>
        <td >
            <a href="/oukcalc/list_operation/?sort=date&dir=<?php echo getDir("date");?>" class="sorter">Дата <?php echo dirText("date");?></a>
        </td>
        <td >
            <a href="/oukcalc/list_operation/?sort=sum&dir=<?php echo getDir("sum");?>" class="sorter">Сумма <?php echo dirText("sum");?></a>
        </td>
        <td >
            <a href="/oukcalc/list_operation/?sort=year&dir=<?php echo getDir("year");?>" class="sorter">Год <?php echo dirText("year");?></a>
        </td>
        <td >
            Просмотр
        </td>
    </tr>
    <?php
    $i = 0;
    foreach ($oper as $a) {
        $i++;
        echo '
        <tr >
            <td class="n">
                '.$i.'
            </td>
            <td >
                '.$a->stage->name.'
            </td>
             <td>
                '.$a->date.'
            </td>
            <td class="float_value">';
        echo number_format($a->money, 2, ",", " ");
        echo
            '</td>
            <td>
                '.$a->year.'
            </td>
            <td>
                <a href="/oukcalc/list_payment/'.$a->year.'/'.$a->stage->id.'">Просмотр</a>
            </td>
            ';
        echo
        '</tr>';
    }
    ?>
</table>

<?php
function getDir($sort) {
    if (!isset($_GET['dir']) || !isset($_GET['sort'])) {
        return 'asc';
    } else
        if ($_GET['sort'] == $sort && $_GET['dir'] == 'asc') {
            return 'desc';
        } else {
            return 'asc';
        }
}

function dirText($sort) {
    if (!isset($_GET['dir'])) {
        return;
    }
    if (isset($_GET['sort']) && $_GET['sort'] == $sort) {
        $d = getDir($sort);
        if ($d == 'asc') {
            return "(по убыванию)";
        } else if ($d == 'desc') {
            return "(по возрастанию)";
        }
    }
}

function formatDate($date) {
    return date("d.m.Y H:i", strtotime($date));
}
?>

