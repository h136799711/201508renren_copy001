<?php

namespace Addons\WeixinMsgSend;
use Common\Controller\Addon;
defined("PROJECT_NAME") || die('DENY ACCESS');


/**
 * 微信公众号消息发送插件插件
 * @author hebidu
 */

    class WeixinMsgSendAddon extends Addon{

        public $info = array(
            'name'=>'WeixinMsgSend',
            'title'=>'微信公众号消息发送插件',
            'description'=>'给指定微信用户发送一条消息',
            'status'=>1,
            'author'=>'hebidu',
            'version'=>'0.1'
        );

        public $admin_list = array(
            'model'=>'msg_send_his',		//要查的表
			'fields'=>'*',			//要查的字段
			'map'=>'',				//查询条件, 如果需要可以再插件类的构造方法里动态重置这个属性
			'order'=>'id desc',		//排序
        );

        public $custom_adminlist = 'adminlist.html';

        public function install(){
            return true;
        }

        public function uninstall(){
            return true;
        }

        //实现的send_msg_to_user钩子方法
        public function send_msg_to_user($param){
            //TODO: 发送消息插件
            trace($param);
        }

    }