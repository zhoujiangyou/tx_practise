<?php
/**
 * 用来操作数据结构
 * Created by PhpStorm.
 * User: zht
 * Date: 2018/1/23
 * Time: 19:46
 */

interface dataOperate{
    public function readData();
    public function writeDate($data);
}

class xmlData implements dataOperate{

    protected  $path;
    public function __construct($xmlPath)
    {
        $this->path=$xmlPath;
    }

    public function readData(){
        $xml=@simplexml_load_file($this->path);
        if(empty($xml)){
           exit("content read faild");
        }
        foreach($xml->seat as $Xseat) {
            $seats[] = get_object_vars($Xseat);//获取对象全部属性，返回数组
        }
        return $seats;
    }
    public function writeDate($data){
        $amount=count($data);
        if($amount==7800){
            $_fp = @fopen('./seat.xml','w');
            if(!$_fp){
                exit('系统错误，文件不存在！');
            }
            flock($_fp,LOCK_EX);
            $_string = "<?xml version=\"1.0\" encoding=\"utf-8\"?>\r\t";
            fwrite($_fp, $_string,strlen($_string));
            $_string = "<data>\r\t";
            fwrite($_fp, $_string,strlen($_string));
            for($i=0;$i<7800;$i++){
                $_string = "<seat>\r\t";
                fwrite($_fp, $_string,strlen($_string));
                $_string = "\t<seatnum>{$data[$i]['seatnum']}</seatnum>\r\t";
                fwrite($_fp, $_string,strlen($_string));
                $_string = "\t<ischoosed>{$data[$i]['ischoosed']}</ischoosed>\r\t";
                fwrite($_fp, $_string,strlen($_string));
                $_string = "</seat>\r\t";
                fwrite($_fp, $_string,strlen($_string));
            }
            $_string = "</data>\r\t";
            fwrite($_fp, $_string,strlen($_string));
            flock($_fp,LOCK_UN);
            fclose($_fp);
        }
    }
}
//主处理类
class mainDeal{
    protected $operateObject;
    public function __construct(dataOperate $object)
    {
        $this->operateObject=$object;
    }


    public function read(){
     return $this->operateObject->readData();
    }

    public function write($data){
        return $this->operateObject->writeDate($data);
    }
}
//
//$main = new mainDeal(new xmlData('seat.xml'));
//var_dump($main->read());

