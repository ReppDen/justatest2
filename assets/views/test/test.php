
<?php
//
//foreach ($calcs as $c) {
//    echo ''
//    ." ".$c->year
//    ." ".$c->stage_id
//    ." ".$c->operation->idoperation
//        ."<br/>";
//
//}

foreach ($calcs as $c) {
    echo $c->year
        ." ".$c->stage_id
        ."<br/>";

}
echo '<pre>';
print_r($cols);
echo '</pre>';






//}
?>