<?php
/**
 * Created by PhpStorm.
 * User: zht
 * Date: 2018/1/23
 * Time: 17:44
 */


/**
 * 根据条件计算得出座位最多26排
 * 根据当前座位号定义 ，讲座位号转换成 X区X排X号位。
 * 可根据数值大小 确定在第几区，
 * 根据等差数列求和公式倒推在第几排，最后计算出在第几位.
 * @param $num
 * @return array
 */
function NumToSeat($num){
    if($num>0&&$num<7801){
        $wei=0; //几号位
        $pai =0;//第几排
        if(in_array($num,[1950,3900,5850,7800])){
            $wei=100;
            $pai=26;
        }else{
            $cal_num =intval(floor($num%1950));
            for($i=1;$i<27;++$i){
                $sum_num =calAllSum($i);
                if($sum_num>=$cal_num){
                    $wei=$cal_num - calAllSum($i-1);
                    $pai=$i;
                    break;
                }
            }
        }
        return ['wei'=>$wei,'pai'=>$pai];
    }else{
        exit("seat num is error ,please check ");
    }
}


/**
 * 根据座位号计算当前所处区域
 * @param $num
 * @return string
 */
function calArea($num){
    if($num>0&&$num<7801){
        $area_name='';
        //排除四个点 1950 3900 5850 7800
        if(in_array($num,[1950,3900,5850,7800])){
             switch ($num){
                 case 1950:
                     $area_name="A";
                     break;
                 case 3900:
                     $area_name="B";
                     break;
                 case 5850:
                     $area_name="C";
                     break;
                 case 7800:
                     $area_name="D";
                     break;
             }

        }else{
        $area = intval(floor($num/1950));
        switch ($area){
            case 0:
                $area_name="A";
                break;
            case 1:
                $area_name="B";
                break;
            case 2:
                $area_name="C";
                break;
            case 3:
                $area_name="D";
                break;
        }
    }
        return $area_name;
    }else{
        exit("seat num is error ,please check ");
    }
}

/**
 * 计算第几排有多少位
 * @param $pai
 * @return number
 */
function calPaiSum($pai){
    if($pai==0){
       $sum =0;
    }else{
        $sum =50+2*($pai);
    }
    return $sum;
}

/**
 * 计算第n排共有多少座位
 * @param $pai
 */
function calAllSum($pai){

    return pow($pai,2)+49*$pai;
}

/**
 * 美化输出格式
 * @param $data
 */
function dump($data){

    echo "ticks just as follows \n";
    foreach ($data as $value){
        echo "{$value['area']} area, {$value['pai']} row , {$value['wei']} position \n";
    }

}


