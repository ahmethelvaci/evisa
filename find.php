<?php

$array = array( '1*0');


foreach ($array as $value) {
    if(!file_exists('-pdf/' . $value . '.pdf'))
        echo $value . "<br>";
}
