<script>
    $(document).ready(function() {
        $("#set_date").click(function() {
            var index = window.location.href.lastIndexOf('?');
            var params = "";
            if (index > 0) {
                params = window.location.href.substring(index);
            }

            location.href="/uvp/list_calc/" + $("#year").val() + "/" + params;
        });

        $("#sort").val($.url().param("sort"));
    });

    function delete_uvp(id) {
        $.ajax({
            type: "GET",
            url: "/ajax/delete_uvp/" + id,
            success: function (res) {
                $.jGrowl("Запись успешно удалена!");
                $("#tr_" + id).remove();
            },
            error: function(res) {
                $.jGrowl("Произошла ошибка во время запроса к серверу");
            }
        });
    }
</script>

<fieldset>
    <legend>Список всех расчетов за <?php echo $year; ?> год</legend>

    <table>
        <tr>
            <td>
                <div style="padding-bottom: 10px;">Посмотреть за год:</div>
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
                <Button id="set_date" class="btn fix_button">Посмотреть</Button>
            </td>

        </tr>
    </table>

</fieldset>

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
<table class="table">
    <tr>
        <td>
            №
        </td>
        <td>
            <a href="/uvp/list_calc/<?php echo $year;?>/?sort=type&dir=<?php echo getDir("type");?>" class="sorter">Тип расчета<?php echo dirText("type");?></a>
        </td>
        <td>
            <a href="/uvp/list_calc/<?php echo $year;?>/?sort=fio&dir=<?php echo getDir("fio");?>" class="sorter">ФИО<?php echo dirText("fio");?></a>
        </td>
        <td>
            <a href="/uvp/list_calc/<?php echo $year;?>/?sort=date&dir=<?php echo getDir("date");?>" class="sorter">Дата<?php echo dirText("date");?></a>
        </td>
        <td>
           <a href="/uvp/list_calc/<?php echo $year;?>/?sort=sum&dir=<?php echo getDir("sum");?>" class="sorter">Баллы<?php echo dirText("sum");?></a>
        </td>
        <td>
            Детали
        </td>
        <?php
        if ($can_delete) {
            echo '<td>
                Удалить
            </td>';
        }
        ?>
    </tr>
    <?php
    $i = 0;
    foreach ($uvp as $a) {
        $i++;
        echo '
        <tr id="tr_'.$a->iduvp_calc.'">
            <td>
                '.$i.'
            </td>
            <td>
                '.$a->uvp_stage->name.'
            </td>
            <td>
                '.$a->user->fio.'
            </td>
            <td>
                '.formatDate($a->date).'
            </td>
            <td>
               '.$a->sum.'
            </td>
           ';
        echo '
            <td>
                <a href="/uvp/watch/'.$a->iduvp_calc.'">Детали</a>
            </td>';
        if ($can_delete) {
            echo '
                <td>
                    <a href="#" onclick="delete_uvp('.$a->iduvp_calc.')">Удалить</a>
                </td>
            ';
        }
        echo '</tr>';
    }
    ?>
</table>

