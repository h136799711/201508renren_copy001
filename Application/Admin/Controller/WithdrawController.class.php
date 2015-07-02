<?php
/**
 * Created by PhpStorm.
 * User: hebidu
 * Date: 15/7/2
 * Time: 13:46
 */

namespace Admin\Controller;


class WithdrawController extends AdminController{
    protected  function _initialize(){
        parent::_initialize();
    }

    /**
     * 提现审核
     */
    public function verify(){
        $this->display();
    }

    /**
     * 提现历史查询
     */
    public function query(){
        $this->display();
    }
}