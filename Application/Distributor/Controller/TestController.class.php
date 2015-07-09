<?php
namespace Distributor\Controller;
use Distributor\Api\CommissionCountApi;
use Think\Controller;

class TestController extends Controller{
	
	public function index(){
		$uid=224;
		$id_arr=array(
			'order_id'=>1,
		);
		$result=apiCall(CommissionCountApi::ADD,array($uid,$id_arr));
		dump($result);
	}
}
