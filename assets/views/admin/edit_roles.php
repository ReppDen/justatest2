<script>
    $(document).ready(function() {


        $("a.savelink").click(function() {
            console.log(this);
            var uid = $(this).attr('id');

            var fio = $('#fio_'+ uid).val();
            var email = $('#email_'+ uid).val();
            var fac = $('#fac_'+ uid).val();
            var uvp = $('#uvp_'+ uid).val();
            var ouk = $('#ouk_'+ uid).val();
            var param = {
                'uid':uid,
                'fio': fio,
                'email' : email,
                'fac': fac,
                'uvp':uvp,
                'ouk':ouk
            }

            console.log($.param(param));

            $.ajax({
                type: "GET",
                data: param,
                url: "/ajax/save_user/",
                success: function (res) {
                    $.jGrowl("Запись с id " + uid + " успешно сохранена!");
                },
                error: function(res) {
                    $.jGrowl("Произошла ошибка во время запроса к серверу! id = " + uid);
                }
            });
        });

    });

    function delete_ouk(id) {
        if (confirm("Внимание! После удаления необходимо произвести перерасчет премий ОУК. Удаляем запись?")) {
            $.ajax({
                type: "GET",
                url: "/ajax/delete_oukuser/" + id,
                success: function (res) {
                    $.jGrowl("Запись успешно удалена!");
                    $("#tr_" + id).remove();
                },
                error: function(res) {
                    $.jGrowl("Произошла ошибка во время запроса к серверу");
                }
            });
        }
    }
</script>


<h3>Настройка ролей пользователей</h3>
<blockquote>Измените строку таблицы и нажмите "Сохранить" для фиксации изменений</blockquote>
<div>
    <table class="table">
        <tr>
            <td>
                ID
            </td>
            <td>
                <a href="#"
                   class="sorter">ФИО<?php echo dirText("type"); ?></a>
            </td>
            <td>
                <a href="#"
                   class="sorter">Email<?php echo dirText("date"); ?></a>
            </td>
            <td>
                <a href="#"
                   class="sorter">Факультет<?php echo dirText("sum"); ?></a>
            </td>
            <td>
                <a href="#"
                   class="sorter">УВП<?php echo dirText("user"); ?></a>
            </td>
            <td>
                <a href="#"
                   class="sorter">ОУК<?php echo dirText("user"); ?></a>
            </td>
            <td>
                Сохранить
            </td>
        </tr>
        <?php
        $i = 0;

        foreach ($users as $u) {
            $i++;
            echo '
        <tr id="tr_' . $u->id . '">
            <td>
                ' . $u->id . '
            </td>
            <td>
                <input id="fio_'.$u->id.'" value="' . $u->fio . '" type="text" reqired/>
            </td>
            <td>
                <input id="email_'.$u->id.'" value="' . $u->email . '" type="email" style="width:150px;" reqired/>
            </td>
            <td>
               ' . select_fac($u, $facs) . '
            </td>
            <td>
               ' . select_assist($u, $assist) . '
            </td>
            <td>
               ' . select_ouk($u, $ouk) . '
            </td>
        ';
            echo '
            <td>
                <a id="'.$u->id.'" class="savelink" href="#">Сохранить</a>
            </td>';
            echo '</tr>';
        }
        ?>
</div>



<?php
function getDir($sort)
{
    if (!isset($_GET['dir']) || !isset($_GET['sort'])) {
        return 'asc';
    } else
        if ($_GET['sort'] == $sort && $_GET['dir'] == 'asc') {
            return 'desc';
        } else {
            return 'asc';
        }
}

function dirText($sort)
{
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

function formatDate($date)
{
    return date("d.m.Y H:i", strtotime($date));
}

function select_fac($u, $facult)
{
    $res = '<select id="fac_' . $u->id . '" reqired>';
    foreach ($facult as $f) {
        if ($u->faculties_id == $f['id']) {
            $res .= "<option value=" . $f['id'] . " selected>" . $f['name'] . "</option>";
        } else {
            $res .= "<option value=" . $f['id'] . ">" . $f['name'] . "</option>";
        }

    }
    $res .= '</select>';
    return $res;

}

function select_assist($u, $assist)
{
    $res = '<select id="uvp_' . $u->id . '" reqired>';
    foreach ($assist as $f) {
        if ($f['id'] == 0 || $u->assist_type_id == $f['id']) {
            $res .= "<option value=" . $f['id'] . " selected>" . $f['name'] . "</option>";
        } else {
            $res .= "<option value=" . $f['id'] . ">" . $f['name'] . "</option>";
        }

    }
    $res .= '</select>';
    return $res;

}

function select_ouk($u, $ouk)
{
    $res = '<select id="ouk_' . $u->id . '" reqired>';
    foreach ($ouk as $f) {
        if ($f['id'] == 0 || $u->ouk_faculty_idouk_faculty == $f['id']) {
            $res .= "<option value=" . $f['id'] . " selected>" . $f['name'] . "</option>";
        } else {
            $res .= "<option value=" . $f['id'] . ">" . $f['name'] . "</option>";
        }

    }
    $res .= '</select>';
    return $res;

}

?>