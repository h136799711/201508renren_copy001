<?php 
namespace Admin\Controller;
use Think\Controller;
use Weixin\Api\WxuserApi;
use Weixin\Api\WxuserFamilyApi;
use Weixin\Api\WxaccountApi;
use Admin\Api\WeixinLogApi;
use Admin\Api\MemberApi;
use Admin\Api\ConfigApi;
use Shop\Api\ProductApi;
use Shop\Api\OrdersApi;
use Ucenter\Api\UcenterMemberApi;
use Shop\Api\WalletApi;
use Shop\Api\WalletHisApi;
use Shop\Api\WithdrawApi;


class QueryTableInfoController extends Controller{
	
	public function index(){
		$table=I("tableName","wxuser");
		$sort=I("sort","desc");
		$title=I("columnName","");
		if($title==""){
			$title=$this->setTitle($table);
		}
		$order=$order=$title." ".$sort;
		//dump($order);
		$result=$this->select($table,$order);
		//dump($result['info']);
		$keys=array();
		if(count($result['info'])!=0){
			$keys=array_keys($result['info'][0]);
		}
		$this->assign('listKey',$keys);
		//dump($keys);
		$tableArray=array('wxuser','wxuser_family','wxaccount','member','product','weixin_log','orders','ucenter_member','wallet_his','wallet','withdraw','config');
		$this->assign('tableArray',$tableArray);
		$this->assign('tableName',$table);
		$this->assign('list',$result['info']);
		$this->assign('columnName',$title);
		$this->assign('sort',$sort);
		$this->display();
	}
	
	/**
	 * 根据表设置默认排序对象
	 */
	private function setTitle($table){
		if($table=="wxuser"){
			$title="create_time";
		}else if($table=="wxuser_family"){
			$title="createtime";
		}else if($table=="wxaccount"){	
			$title="createtime";
		}else if($table=="member"){
			$title="update_time";
		}else if($table=="product"){
			$title="createtime";
		}else if($table=="weixin_log"){
			$title="ctime";
		}else if($table=="orders"){
			$title="updatetime";
		}else if($table=="ucenter_member"){
			$title="update_time";
		}else if($table=="wallet_his"){
			$title="create_time";
		}else if($table=="wallet"){
			$title="update_time";
		}else if($table=="withdraw"){
			$title="update_time";
		}else if($table=="config"){
			$title="update_time";
		}
		return $title;
	}
	
	private function select($table,$order){
		if($table=="wxuser"){
			$result=apiCall(WxuserApi::QUERY_NO_PAGING,array($map,$order));
		}else if($table=="wxuser_family"){
			$result=apiCall(WxuserFamilyApi::QUERY_NO_PAGING,array($map,$order));
		}else if($table=="wxaccount"){
			$result=apiCall(WxaccountApi::QUERY_NO_PAGING,array($map,$order));
		}else if($table=="member"){
			$result=apiCall(MemberApi::QUERY_NO_PAGING,array($map,$order));
		}else if($table=="product"){
			$result=apiCall(ProductApi::QUERY_NO_PAGING,array($map,$order));
		}else if($table=="weixin_log"){
			$result=apiCall(WeixinLogApi::QUERY_NO_PAGING,array($map,$order));
		}else if($table=="orders"){
			$result=apiCall(OrdersApi::QUERY_NO_PAGING,array($map,$order));
		}else if($table=="ucenter_member"){
			$result=apiCall(UcenterMemberApi::QUERY_NO_PAGING,array($map,$order));
		}else if($table=="wallet_his"){
			$result=apiCall(WalletHisApi::QUERY_NO_PAGING,array($map,$order));
		}else if($table=="wallet"){
			$result=apiCall(WalletApi::QUERY_NO_PAGING,array($map,$order));
		}else if($table=="withdraw"){
			$result=apiCall(WithdrawApi::QUERY_NO_PAGING,array($map,$order));
		}else if($table=="config"){
			$result=apiCall(ConfigApi::QUERY_NO_PAGING,array($map,$order));
		}
		return $result;
	}
	
	
	public function changeColumn(){
		$table=I("tableName","wxuser");
		$sort=I("sort","desc");
		$title=I("columnName","");
		
		
		/*dump($table);
		dump($sort);
		dump($title);*/
		if($title==""){
			$title=$this->setTitle($table);
		}
		$order=$order=$title." ".$sort;
		$result=$this->select($table,$order);
		$keys=array();
		if(count($result['info'])!=0){
			$keys=array_keys($result['info'][0]);
		}
		//dump($result);
		$this->success($keys);
	}
	
	/**
	 * 修改订单状态
	 */
	public function changeOrderStatus(){
		$map=array(
			'order_status'=>5
		);
		$result=apiCall(OrdersApi::SAVE_BY_ID,array(41,$map));
		dump($result);
	}
	//删除
	/*public function delUser(){
		$uid=I('get.uid',0);
		if($uid!=0){
			$map=array(
				'uid'=>$uid,
			);
			$result1=apiCall(WxuserApi::DELETE,array($map));
			$result2=apiCall(MemberApi::DELETE,array($map));
			$map=array(
				'id'=>$uid,
			);
			$result3=apiCall(UcenterMemberApi::DELETE,array($map));
			dump($result1);
			dump($result2);
			dump($result3);
			dump("删除成功");
		}else{
			dump('uid号不存在');
		}
		
	}*/
	
}
