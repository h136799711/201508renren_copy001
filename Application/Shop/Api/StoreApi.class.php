<?php
// .-----------------------------------------------------------------------------------
// | WE TRY THE BEST WAY 杭州博也网络科技有限公司
// |-----------------------------------------------------------------------------------
// | Author: 贝贝 <hebiduhebi@163.com>
// | Copyright (c) 2013-2016, http://www.itboye.com. All Rights Reserved.
// |-----------------------------------------------------------------------------------
namespace Admin\Api;

use Common\Api\Api;
use Common\Model\WxstoreModel;
use Think\Page;

/**
 *
 * Class WxstoreApi
 * @package Admin\Api
 * @author 老胖子-何必都 <hebiduhebi@126.com>
 */
class WxstoreApi extends Api
{

    /**
     *  查询商品信息
     */
    const  QUERY_PRODUCT_BY_UID = "Admin/Wxstore/queryProduct";
    /**
     * 获取单条信息
     */
    const  GET_INFO = "Admin/Wxstore/getInfo";

    protected function _init()
    {
        $this->model = new WxstoreModel();
    }


    /**
     * @param $uid
     * @param array $page
     * @param bool $order
     * @param bool $params
     * @return array
     */
    public function queryProduct($uid, $page = array('curpage' => 0, 'size' => 10), $order = false, $params = false){
        $query = $this->model->alias("st")->join("LEFT JOIN __WXPRODUCT__ as wp on wp.storeid = st.id")->where(array("st.uid"=>$uid));

        $query -> page($page['curpage'] . ',' . $page['size']) ->select();


		$count = $this->model->alias("st")->join("LEFT JOIN __WXPRODUCT__ as wp on wp.storeid = st.id")->where(array("st.uid"=>$uid)) -> count();
		// 查询满足要求的总记录数
		$Page = new Page($count, $page['size']);

		//分页跳转的时候保证查询条件
		if ($params !== false) {
			foreach ($params as $key => $val) {
				$Page -> parameter[$key] = urlencode($val);
			}
        }

        // 实例化分页类 传入总记录数和每页显示的记录数
        $show = $Page->show();

        return $this->apiReturnSuc(array("show" => $show, "list" => $list));
    }

}

