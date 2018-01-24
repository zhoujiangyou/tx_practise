<?php
/**
 * Created by PhpStorm.
 * User: zht
 * Date: 2018/1/24
 * Time: 16:50
 */
require_once "cal.php";
require_once "data.php";

//根据买票情况获取数据资源，计算得出结果
class server{

    protected $mainDeal;
    protected $unchoosedAll;
    protected $bestSeats;
    protected $comSeats;
    protected $badSeats;
    public function __construct(mainDeal $mainDeal)
    {
        $this->mainDeal=$mainDeal;
        $this->unchoosedAll=$mainDeal->readUnchoosed();
        $this->bestSeats=$mainDeal->getBest();
        $this->comSeats=$mainDeal->getCom();
        $this->badSeats=$mainDeal->getBad();
    }


    /**
     * 优区有座位就选出，没有就依次掉级选取
     * 获取一张票
     */
    public function getOne(){
        if(count($this->bestSeats)>=1){
            $rand_seat=array_rand($this->bestSeats,1);
        }else{
            if(count($this->comSeats)>=1){
                $rand_seat=array_rand($this->bestSeats,1);
            }else{
                $rand_seat=array_rand($this->badSeats,1);
            }
        }
        return $rand_seat;
    }

    public function getMang($num){


    }

    /**
     *
     * 在给定区域内，随机出一个座位
     * 查找给定座位上下左右相邻座位。
     * @param $area
     */
    protected  function findNextSeat($area){


    }




}