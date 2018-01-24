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
    public function readChoosedData();
    public function readUnchoosedData();
}

class xmlData implements dataOperate{

    protected  $path;
    protected  $data;
    public function __construct($xmlPath)
    {
        $this->path=$xmlPath;
        $this->data=[];
    }

    /**
     * xml文件读取
     * @return array
     */
    public function readData(){
        $xml=@simplexml_load_file($this->path);
        if(empty($xml)){
           exit("content read faild,please run 'php make_testdata.php' first");
        }
        foreach($xml->seat as $Xseat) {
            $this->data[] = get_object_vars($Xseat);//获取对象全部属性，返回数组
        }
        return $this->data;
    }

    /**
     * xml文件写入
     * @param $data
     */
    public function writeDate($data){
        $amount=count($data);
        //固定7800 ，不过这边优化成动态配置，防止之后体育场变了。。。
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

    /**
     * xml文件读取,读取状态为选中的座位 ischoosed = 1
     * @return array
     */
    public function readChoosedData(){
        $data = $this->data;
        if(count($data)!=0){
            foreach ($data as $key=>$value){
                if($value['ischoosed']==0){
                    unset($data[$key]);
                }
            }
            return $data;
        }
        return [];
    }

    /**
     * xml文件读取,读取状态为未选中的座位 ischoosed = 0
     * @return array
     */
    public function readUnchoosedData(){
        $data = $this->data;
        if(count($data)!=0){
            foreach ($data as $key=>$value){
                if($value['ischoosed']==1){
                    unset($data[$key]);
                }
            }
            return $data;
        }
        return [];
    }

    /**
     *获取未选择优区域座位
     * seatNum B前十排:1951-2540 C前十排:3901-4490 总位数为590*2 = 1180
     * 数据对应实际键值小1
     *
     */
    public function getBestUnchoosedSeat(){
        $data = $this->data;
        if(count($data)!=0){
            foreach ($data as $key=>$value){
                if(($key>1949&&$key<2540)||($key>3899&&$key<4490)){
                    if($value['ischoosed']==1){
                        unset($data[$key]);
                    }
                }else{
                    unset($data[$key]);
                }
            }
            return $data;
        }
        return [];
    }

    /**
     *获取未选择良区域座位
     * seatNum A前十排：1-590 D前十排：5851-6440 B 11-16排:2541-3900 C 11-16排:4491-5850  总位数3900
     * 数据对应实际键值小1
     */
    public function getComUnchoosedSeat(){
        $data = $this->data;
        if(count($data)!=0){
            foreach ($data as $key=>$value){
                if(($key>=0&&$key<590)||($key>5849&&$key<6440)||($key>2539&&$key<3900)||($key>4489&&$key<5850)){
                    if($value['ischoosed']==1){
                        unset($data[$key]);
                    }
                }else{
                    unset($data[$key]);
                }
            }
            return $data;
        }
        return [];
    }

    /**
     *获取未选择列区域
     * seatNUm A 11-16排:591-1950 D 11-16 :6441-7800 总位数为 2720
     * 数据对应实际键值小1
     */
    public function getBadUnchoosedSeart(){
        $data = $this->data;
        if(count($data)!=0){
            foreach ($data as $key=>$value){
                if(($key>589&&$key<1950)||($key>6439&&$key<7800)){
                    if($value['ischoosed']==1){
                        unset($data[$key]);
                    }
                }else{
                    unset($data[$key]);
                }
            }
            return $data;
        }
        return [];
    }
}
//主处理类
class mainDeal{
    protected $operateObject;
    public function __construct(dataOperate $object)
    {
        $this->operateObject=$object;
    }

    /**
     * 读取存储的数据
     * @return mixed
     */
    public function read(){
     return $this->operateObject->readData();
    }

    /**
     * 读取存储的数据 未选中数据
     * @return mixed
     */
    public function readUnchoosed(){
        return $this->operateObject->readUnchoosedData();
    }
    /**
     * 写入更新数据
     * @param $data
     * @return mixed
     */
    public function write($data){
        return $this->operateObject->writeDate($data);
    }
}

