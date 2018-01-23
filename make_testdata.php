<?php
/**
 * 建立测试数据脚本
 * Created by PhpStorm.
 * User: zht
 * Date: 2018/1/23
 * Time: 20:01
 */

$_fp = @fopen('seat.xml','w');
if(!$_fp){
    exit('系统错误，文件不存在！');
}
flock($_fp,LOCK_EX);
$_string = "<?xml version=\"1.0\" encoding=\"utf-8\"?>\r\t";
fwrite($_fp, $_string,strlen($_string));
$_string = "<data>\r\t";
fwrite($_fp, $_string,strlen($_string));
for($i=1;$i<7801;$i++){
    $_string = "<seat>\r\t";
    fwrite($_fp, $_string,strlen($_string));
    $_string = "\t<seatnum>{$i}</seatnum>\r\t";
    fwrite($_fp, $_string,strlen($_string));
    $_string = "\t<ischoosed>0</ischoosed>\r\t";
    fwrite($_fp, $_string,strlen($_string));
    $_string = "</seat>\r\t";
    fwrite($_fp, $_string,strlen($_string));
}
$_string = "</data>\r\t";
fwrite($_fp, $_string,strlen($_string));
flock($_fp,LOCK_UN);
fclose($_fp);