<?php
/**
 * Created by PhpStorm.
 * User: hebidu
 * Date: 15/7/2
 * Time: 14:10
 */

namespace Shop\Model;


use Think\Model;

class WithdrawModel extends Model{

    protected $_auto = array(
        array('create_time','time',self::MODEL_INSERT,"function"),
        array('update_time','time',self::MODEL_BOTH,"function"),
    );

}