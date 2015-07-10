<?php
/**
 * Created by PhpStorm.
 * User: hebidu
 * Date: 15/7/8
 * Time: 14:52
 */

namespace Distributor\Api;
use Weixin\Api\WxuserApi;
use Admin\Api\WxuserGroupApi;
use Shop\Api\OrdersApi;
use Shop\Api\WalletApi;
use Shop\Api\WalletHisApi;
use Weixin\Api\WxuserFamilyApi;
use Distributor\Api\GroupAccessApi;


/**
 * 佣金计算
 * Class CommissionCountApi
 * @package Distributor\Api
 */
class CommissionCountApi implements ICommissionCountInterface{

	const ADD="Distributor/CommissionCount/add";

    /**
     * @param $id_arr 订单ID集合
     */
    function add($id_arr)
    {
    	//遍历订单ID集合
    	foreach($id_arr as $id){
    		$map=array(
    			'id'=>$id
    		);
			
			//获取订单
    		$result=apiCall(OrdersApi::QUERY_NO_PAGING,array($map));
			//获取下单用户ID
			$wxuser_id=$result['info'][0]['wxuser_id'];
			//获取订单价格
			$price=$result['info'][0]['price'];
			$map=array(
    			'id'=>$wxuser_id
    		);
			
			//获取wxuser信息
			$result=apiCall(WxuserApi::QUERY_NO_PAGING,array($map));
			
			//获取uid
			$uid=$result['info'][0]['uid'];
			//获取下单用户昵称
			$nickname=$result['info'][0]['nickname'];
			
	    	$map=array(
	    		'uid'=>$uid
			);
			
			$family=apiCall(WxuserFamilyApi::QUERY_NO_PAGING,array($map));
			if($family['info'][0]['parent_1']!=0){
				$uids[]=$family['info'][0]['parent_1'];
			}
			if($family['info'][0]['parent_2']!=0){
				$uids[]=$family['info'][0]['parent_2'];
			}
			if($family['info'][0]['parent_3']!=0){
				$uids[]=$family['info'][0]['parent_3'];
			}
			if($family['info'][0]['parent_4']!=0){
				$uids[]=$family['info'][0]['parent_4'];
			}
			
			//获取所有分销商信息
			foreach($uids as $u){
				$map=array(
					'uid'=>$u,
				);
				$wxuserInfo=apiCall(WxuserApi::QUERY_NO_PAGING,array($map));
				//查出分销商等级
				$map=array(
					'wxuser_group_id'=>$wxuserInfo['info'][0]['groupid'],
				);
				$groupAccess=apiCall(GroupAccessApi::QUERY_NO_PAGING,array($map));
				$commission=(float)$groupAccess['info'][0]['percent']*(float)$price; //佣金提成比例*价格=佣金
				$map=array(
					'uid'=>$u
				);
				$WalletInfo=apiCall(WalletApi::QUERY_NO_PAGING,array($map));
				$result=apiCall(WalletApi::SETINC,array($map,'account_balance',$commission)); //添加佣金
				
				$percent=(float)$groupAccess['info'][0]['percent']*100;
				$map=array(
					'uid'=>$u,
					'before_money'=>$WalletInfo['info'][0]['account_balance'],
					'plus'=>$commission,
					'minus'=>0,
					'after_money'=>(float)$WalletInfo['info'][0]['account_balance']+(float)$commission,
					'create_time'=>time(),
					'reason'=>'用户'.$nickname.'(ID:'.$wxuser_id.')'.'下单，分销商'.$wxuserInfo['info'][0]['nickname'].'(ID:'.$u.')获得佣金'.$commission.'元('.$percent.'%)',
				);
				$result=apiCall(WalletHisApi::ADD,array($map));
			}
			
			
    	}
		
		
    	//先查出佣金得利者身份等级
    	/*
    	$map=array(
    		'uid'=>$uid
		);
		
		$family=apiCall(WxuserFamilyApi::QUERY_NO_PAGING,array($map));
		if($family['info'][0]['parent_1']!=0){
			$uids[]=$family['info'][0]['parent_1'];
		}
		if($family['info'][0]['parent_2']!=0){
			$uids[]=$family['info'][0]['parent_2'];
		}
		if($family['info'][0]['parent_3']!=0){
			$uids[]=$family['info'][0]['parent_3'];
		}
		if($family['info'][0]['parent_4']!=0){
			$uids[]=$family['info'][0]['parent_4'];
		}
		//获取所有
		for(int $i=0;$i<count($uids);$i++){
			$uids[$i]
		}
		
		
		$result=apiCall(WxuserApi::QUERY_NO_PAGING,array($map));
		$groupid=$result['info'][0]['groupid']; //级别
		$map=array(
			'id'=>$id_arr['order_id']
		);
		$result=apiCall(OrdersApi::QUERY_NO_PAGING,array($map));
		$price=(float)$result['info'][0]['price']; //商品总价
		$ratio=0;
		if($groupid==11){
			$ratio=0.3;
		}else if($groupid==12){
			$ratio=0.2;
		}else if($groupid==13){
			$ratio=0.1;
		}else{
			return;
		}
		$trans = M();
        $trans->startTrans(); //开启事务
		$commission=$ratio*$price;
		//
		$map=array(
			'uid'=>$uid
		);
	
		$result1=apiCall(WalletApi::QUERY_NO_PAGING,array($map));
		
		$result=apiCall(WalletApi::SETINC,array($uid,'account_balance',$commission)); //添加佣金
		if($result['status']){
			$map=array(
				'uid'=>$uid,
				'before_money'=>$result1['info'][0]['account_balance'],
				'plus'=>$commission,
				'minus'=>0,
				'after_money'=>(float)$result1['info'][0]['account_balance']+(float)$commission,
				'create_time'=>time(),
				'reason'=>'用户结算，获利'
			);
			$result=apiCall(WalletHisApi::ADD,array($map));
			if($result['status']){
				$trans->commit();
			}else{
				$trans->rollback();
			}
		}else{
			$trans->rollback();
		}*/
        // TODO: 计算佣金，并记录到数据库中。
		
    }
}