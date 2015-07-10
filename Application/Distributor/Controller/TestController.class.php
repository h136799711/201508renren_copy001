<?php
namespace Distributor\Controller;
use Distributor\Api\CommissionCountApi;
use Think\Controller;
use Distributor\Api\GroupAccessApi;

class TestController extends Controller{
	
	public function index(){
		/*$id_arr=array(1);
		apiCall(CommissionCountApi::ADD,array($id_arr));*/
		dump(time());
	}
}
