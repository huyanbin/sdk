<?php 
namespace Home\Controller;
use Think\Controller;

Class LoginController extends Controller{
	//授权回调地址
	public function callback($type = null, $code = null){
		(empty($type) || empty($code)) && $this->error('参数错误1');

		//加载ThinkOauth类并实例化一个对象
		$name = ucfirst(strtolower($type)) . 'SDK';
    	$names="Common\OauthSDK\sdk"."\\".$name;
		$oauth=new $names();
		//腾讯微博需传递的额外参数
		$extend = null;
		// if($type == 'tencent'){
		// 	$extend = array('openid' => $this->$_GET('openid'), 'openkey' => $this->$_GET('openkey'));
		// }

		//请妥善保管这里获取到的Token信息，方便以后API调用
		//调用方法，实例化SDK对象的时候直接作为构造函数的第二个参数传入
		//如： $qq = ThinkOauth::getInstance('qq', $token);
		$token = $oauth->getAccessToken($code , $extend);

		//获取当前登录用户信息
		if(is_array($token)){
			$oauth=new \Common\Controller\TypeEvent();
			$user_info = $oauth->$type($token);

			echo("<h1>恭喜！使用 {$type} 用户登录成功</h1><br>");
			echo("授权信息为：<br>");
			dump($token);
			echo("当前登录用户信息为：<br>");
			dump($user_info);
		}
	}
}