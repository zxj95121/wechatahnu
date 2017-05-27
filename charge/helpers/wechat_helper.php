<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * CodeIgniter wechat Helpers
 *
 * @package		CodeIgniter
 * @subpackage	Helpers
 * @category	Helpers
 * @author		张贤健
 * @link		https://codeigniter.com/user_guide/helpers/url_helper.html
 */

// ------------------------------------------------------------------------

if ( ! function_exists('get_access_token'))
{
	/*
		默认为service，传入别的值表示为sub订阅号
	 */
	function get_access_token($type = 'service')
	{
		if($type == 'service')
			$url = 'https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid='.APPID.'&secret='.APPSECRET;
		else
			$url = 'https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid='.SUBID.'&secret='.SUBSECRET;
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		$output = curl_exec($curl);
		curl_close($curl);
		return json_decode($output,true);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('https_request'))
{
	//curl发送接口请求信息
	function https_request($url, $data = null){
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
		if (!empty($data)){
			curl_setopt($curl, CURLOPT_POST, 1);
			curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
		}
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		$output = curl_exec($curl);
		curl_close($curl);
		return json_decode($output,true);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('get_global'))
{
	//获取global全局配置
	function get_global(){
		$data = json_decode(file_get_contents(httpd('/public/php/settings/global.php')),true);
		return $data;
	}
}

// ------------------------------------------------------------------------