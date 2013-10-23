<fieldset>
    <legend>Список расчетов УВП <?php echo $year; ?> год</legend>
    <table>
        <tr>
            <td>
                <div style="padding-bottom: 10px;">Этап:</div>
            </td>
            <td>
                <div style="padding-bottom: 10px;">Год:</div>
            </td>
            <td>
                <select id="year" class="year">
                    <?php
                    for ($i = 2012; $i<$year + 2; $i++) {
                        if ($i == $year) {
                            echo '<option value="'.$i.'" selected>'.$i.'</option>';
                        } else {
                            echo '<option value="'.$i.'">'.$i.'</option>';
                        }
                    }
                    ?>
                </select>
            </td>
            <td>
                <Button id="set_filter" class="btn fix_button">Посмотреть</Button>
            </td>

        </tr>
    </table>

</fieldset>
<table class="table table_for_years">
    <tr class="title">
        <td class="n">
            №
        </td>
        <td >
            <a href="/uvp/list_uvp/<?php echo $year;?>/<?php echo $stage?>/?sort=stage&dir=<?php echo getDir("stage");?>" class="sorter">Этап<?php echo dirText("stage");?></a>
        </td>
        <td >
            <a href="/uvp/list_uvp/<?php echo $year;?>/<?php echo $stage?>/?sort=money&dir=<?php echo getDir("money");?>" class="sorter">Сумма<?php echo $year; echo dirText("money");?></a>
        </td>
        <td >
            <a href="/uvp/list_uvp/<?php echo $year;?>/<?php echo $stage?>/?sort=year&dir=<?php echo getDir("year");?>" class="sorter">Год<?php echo dirText("year");?></a>
        </td>
        <td>
            Просмотр
        </td>

    </tr>
    <?php
    $i = 0;
    foreach ($pays as $a) {
        $i++;
        echo '
        <tr id="tr_'.$a->iduvp_operation.'">
            <td class="n">
                '.$i.'
            </td>
            <td>
                '.$a->uvp_stage->name.'
            </td>
            <td class="float_value">'.number_format($a->money, 2, ",", " ").'</td>
            <td>'.$a->year.'</td>
            <td>
                <a href="/uvp/list_payment/'.$a->year.'/'.$a->uvp_stage->iduvp_stage.'">Просмотр</a>
            </td>
        </tr>';
    }
    ?>
</table>

<script>
    $(document).ready(function() {
        $("#set_filter").click(function() {
            var index = window.location.href.lastIndexOf('?');
            var params = "";
            if (index > 0) {
                params = window.location.href.substring(index);
            }

            location.href="/uvp/list_uvp/" + $("#year").val() + "/" + $("#stage").val() + "/" + params;
        });

        $("#sort").val($.url().param("sort"));
    });
</script>

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

