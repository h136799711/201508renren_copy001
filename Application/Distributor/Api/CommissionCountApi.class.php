<?php
/**
 * Created by PhpStorm.
 * User: hebidu
 * Date: 15/7/8
 * Time: 14:52
 */

namespace Distributor\Api;

/**
 * 佣金计算
 * Class CommissionCountApi
 * @package Distributor\Api
 */
class CommissionCountApi implements ICommissionCountInterface{

    /**
     * @param $uid 佣金得利者ID
     * @param $id_arr 订单ID集合
     */
    function add($uid, $id_arr)
    {
        // TODO: 计算佣金，并记录到数据库中。


    }
}