<h3>Просмотр рачета</h3>
<form id="form" method="POST">
        <div class="col_container">
                    <div class="column">
                        <label>Сотрудник</label>
                        <?php
                            echo $uvp->user->fio;
                        ?>
                        <label>Этап</label>
                        <?php
                            echo $uvp->uvp_stage->name;
                        ?>
                        <br/>
                        <label>Год</label>
                        <?php
                            echo $uvp->year;
                        ?>
                        <br/>
                        <label>Расчет</label>
                        <?php
                            echo $uvp->note;
                        ?>
                    </div>
        </div>
</form>
