<fieldset>
    <legend>Детализация выплаты за <?php echo $year; ?> год</legend>
    <table>
        <tr>
            <td>
                <div style="padding-bottom: 10px;">Пользователь:</div>
            </td>
            <td>
                <select id="user" name="user">
                    <?php
                    foreach($users as $s) {
                        if ($s->id == $user) {
                            echo '<option value="'.$s->id.'" selected>'.$s->fio.'</option>';
                        } else {
                            echo '<option value="'.$s->id.'">'.$s->fio.' '.$s->faculty->name.'</option>';
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
                    for ($i = 1970; $i<$year + 20; $i++) {
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
            <a href="/funduser/list_detail/<?php echo $year;?>/<?php echo $user;?>/?sort=stage&dir=<?php echo getDir("stage");?>" class="sorter">Этап<?php echo dirText("stage");?></a>
        </td>
        <td >
            <a href="/funduser/list_detail/<?php echo $year;?>/<?php echo $user?>/?sort=money&dir=<?php echo getDir("money");?>" class="sorter">Год <?php echo $year; echo dirText("money");?></a>
        </td>
    </tr>
    <?php
    $i = 0;
    foreach ($awards as $a) {
        $i++;
        echo '
        <tr id="tr_'.$a->idoperation_stage_user.'">
            <td class="n">
                '.$i.'
            </td>
            <td>
                '.$a->stage->name.'
            </td>
            <td class="float_value">';
        echo number_format($a->money, 2, ",", " ");
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

            location.href="/funduser/list_detail/" + $("#year").val() + "/" + $("#user").val() + "/" + params;
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

