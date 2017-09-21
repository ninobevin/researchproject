<?php







$str = "hello this is bevin and like to remove some part of the string that might not needed.";

$str_arr = explode(" ", $str);

unset($str_arr[count($str_arr) - 2]);

$str = 	implode(" ", $str_arr);


echo $str;













?>