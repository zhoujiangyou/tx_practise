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
                if($value['ischoosed']==1){
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
                if($value['ischoosed']==0){
                    unset($data[$key]);
                }
            }
            return $data;
        }
        return [];
    }

    /**
     *获取优区域座位
     */
    public function readBestData(){}

    /**
     *获取良区域座位
     */
    public function readCommonData(){}

    public function readBadData(){}
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

