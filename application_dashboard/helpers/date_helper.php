<?php 
function weekOfMonth($int_date) {
    $firstOfMonth = date("Y-m-01", $int_date);
    return intval(date("W", $int_date)) - intval(date("W", strtotime($firstOfMonth)));
}

?>