<h3>Просмотр рачета</h3>
<form id="form" method="POST">
        <div class="col_container">
                    <div class="column">
                        <label>Факультет</label>
                        <?php
                            echo $award->faculty->name;
                        ?>
                        <label>Этап</label>
                        <?php
                            echo $award->stage->name;
                        ?>
                        <br/>
                        <label>Год</label>
                        <?php
                            echo $award->year;
                        ?>
                        <br/>
                        <label>Расчет</label>
                        <?php
                            echo $award->note;
                        ?>
                    </div>
        </div>
</form>
