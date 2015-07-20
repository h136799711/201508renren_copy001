<?php 
namespace Admin\Controller;
use Think\Controller;
use Weixin\Api\WxuserApi;
use Weixin\Api\WxuserFamilyApi;
use Weixin\Api\WxaccountApi;
use Admin\Api\MemberApi;


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
		$tableArray=array('wxuser','wxuser_family','wxaccount','member');
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
		}
		return $result;
	}
	
	
	public function changeColumn(){
		$table=I("tableName","wxuser");
		$sort=I("sort","desc");
		$title=I("columnName","");
		if($title==""){
			$title=$this->setTitle($table);
		}
		$order=$order=$title." ".$sort;
		$result=$this->select($table,$order);
		$keys=array();
		if(count($result['info'])!=0){
			$keys=array_keys($result['info'][0]);
		}
		$this->success($keys);
	}
	
}
