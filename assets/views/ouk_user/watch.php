<h3>Просмотр рачета</h3>
<form id="form" method="POST">
        <div class="col_container">
                    <div class="column">
                        <label>Преподаватель</label>
                        <?php
                            echo $ouk->user->fio;
                        ?>
                        <label>Этап</label>
                        <?php
                            echo $ouk->stage->name;
                        ?>
                        <br/>
                        <label>Год</label>
                        <?php
                            echo $ouk->year;
                        ?>
                        <br/>
                        <label>Расчет</label>
                        <?php
                            echo $ouk->note;
                        ?>
                    </div>
        </div>
</form>
