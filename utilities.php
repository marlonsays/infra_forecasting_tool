<?php

function convert_mb_to_gb($mb = 0) {
    if(is_numeric($mb) && $mb >= 0) {
        return $mb * (1/1024);
    } else {
        return 0.00;
    }
}

function convert_gb_to_mb($gb = 0) {
    if(is_numeric($gb) && $gb >= 0) {
        return $gb * 1024;
    } else {
        return 0.00;
    }
}

?>