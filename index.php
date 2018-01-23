<?php
/**
 * 主文件用来执行demo
 * Created by PhpStorm.
 * User: zht
 * Date: 2018/1/23
 * Time: 19:45
 */

//    A B C D  每个区域座位数为1950 总数就是4*1950 = 7800
//    排号规则：
//        A区左下角从1 开始， 到A区右上角座位号为1950
//        B区左下角从1951开始，到B区右上角为3900
//        C区左下角从3901开始，到B区右上角为5850
//        D区左下角从5851开始，到B区右上角为7800
//        每排的座位数依次从左到右从1开始递增，如：1,2,3,4....50
// 暂定用xml存储座位信息


require_once "cal.php";
require_once "data.php";

echo "************** welcome ***************** \n";
echo "please enter the nums you want to get \n";
$num =trim(fgets(STDIN));
$seats=[];
if($num>0&&$num<6){
    //获取全部座位数据
    $main =new mainDeal(new xmlData("seat.xml"));
    $data = $main->read();
    for($i=1;$i<=$num;$i++){
        do{
            $seatNum = rand(0,7799);
        }while($data[$seatNum-1]['ischoosed'] ==1); //数组键值比实际座位大1
        //设置选中座位状态为已选中

        $seat['area']=calArea($seatNum);
        $patwei= NumToSeat($seatNum);
        $seat['pai']=$patwei['pai'];
        $seat['wei']=$patwei['wei'];
        $seats[]=$seat;
        $data[$seatNum-1]['ischoosed'] =1; //数组键值比实际座位大1
    }
    $main->write($data);
    //美化输出
    dump($seats);
}else{
    echo "num is in range 1-5 \n";
}

echo "******************************* \n";
exit();




