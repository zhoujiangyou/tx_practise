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
    public function __construct($mainDeal)
    {
        $this->mainDeal=$mainDeal;
    }

    //获取一张票逻辑
    public function buyOne(){

        //判断当前优区是否还有多余票


    }


}