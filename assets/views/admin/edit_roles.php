<h3>Настройка ролей пользователей</h3>
<div>
    <table class="table">
        <tr>
            <td>
                ID
            </td>
            <td>
                <a href="/admin/edit_roles/?sort=type&dir=<?php echo getDir("type"); ?>"
                   class="sorter">ФИО<?php echo dirText("type"); ?></a>
            </td>
            <td>
                <a href="/admin/edit_roles/?sort=date&dir=<?php echo getDir("date"); ?>"
                   class="sorter">Email<?php echo dirText("date"); ?></a>
            </td>
            <td>
                <a href="/admin/edit_roles/?sort=sum&dir=<?php echo getDir("sum"); ?>"
                   class="sorter">Факультет<?php echo dirText("sum"); ?></a>
            </td>
            <td>
                <a href="/admin/edit_roles/?sort=user&dir=<?php echo getDir("user"); ?>"
                   class="sorter">УВП<?php echo dirText("user"); ?></a>
            </td>
            <td>
                <a href="/admin/edit_roles/?sort=user&dir=<?php echo getDir("user"); ?>"
                   class="sorter">ОУК<?php echo dirText("user"); ?></a>
            </td>
            <td>
                Детали
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
                <input value="' . $u->fio . '" type="text"/>
            </td>
            <td>
                <input value="' . $u->email . '" type="email" style="width:150px;"/>
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
                <a href="/admin/watch/' . $u->fio . '">Детали</a>
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
    $res = '<select id="fac_' . $u->id . '">';
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
    $res = '<select id="assist_' . $u->id . '">';
    foreach ($assist as $f) {
        if ($f['id'] == null || $u->assist_type_id == $f['id']) {
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
    $res = '<select id="assist_' . $u->id . '">';
    foreach ($ouk as $f) {
        if ($f['id'] == null || $u->ouk_faculty_idouk_faculty == $f['id']) {
            $res .= "<option value=" . $f['id'] . " selected>" . $f['name'] . "</option>";
        } else {
            $res .= "<option value=" . $f['id'] . ">" . $f['name'] . "</option>";
        }

    }
    $res .= '</select>';
    return $res;

}

?>