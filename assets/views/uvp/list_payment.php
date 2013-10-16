<fieldset>
    <legend>Список выплат по факультетам за <?php echo $year; ?> год</legend>
    <table>
        <tr>
            <td>
                <div style="padding-bottom: 10px;">Этап:</div>
            </td>
            <td>
                <select id="stage" name="stage">
                    <?php
                    foreach($stages as $s) {
                        if ($s->iduvp_stage == $stage) {
                            echo '<option value="'.$s->iduvp_stage.'" selected>'.$s->name.'</option>';
                        } else {
                            echo '<option value="'.$s->iduvp_stage.'">'.$s->name.'</option>';
                        }
                    }
                    ?>
                </select>
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
            <a href="/uvp/list_payment/<?php echo $year;?>/<?php echo $stage?>/?sort=fio&dir=<?php echo getDir("fio");?>" class="sorter">ФИО<?php echo dirText("fio");?></a>
        </td>
        <td >
            <a href="/uvp/list_payment/<?php echo $year;?>/<?php echo $stage?>/?sort=money&dir=<?php echo getDir("money");?>" class="sorter">Год <?php echo $year; echo dirText("money");?></a>
        </td>
    </tr>
    <?php
    $i = 0;
    foreach ($pays as $a) {
        $i++;
        echo '
        <tr id="tr_'.$a->iduvp_payment.'">
            <td class="n">
                '.$i.'
            </td>
            <td>
                '.$a->user->fio.'
            </td>
            <td class="float_value">';
        echo number_format($a->payment, 2, ",", " ");
        echo
            '</td>

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

            location.href="/uvp/list_payment/" + $("#year").val() + "/" + $("#stage").val() + "/" + params;
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

