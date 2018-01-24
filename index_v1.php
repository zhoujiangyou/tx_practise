<?php
/**
 * Created by PhpStorm.
 * User: zht
 * Date: 2018/1/24
 * Time: 16:46
 */

echo "************** welcome  V2 ***************** \n";
echo "please enter the nums you want to get \n";
$num =trim(fgets(STDIN));
if(!is_numeric($num)){
    exit("please enter the number of numeric");
}
if($num>0&&$num<6){




}else{
    echo "num is in range 1-5 \n";
}

echo "******************************* \n";
exit();