<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cnet_gbk extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
	}
	
	public function index()
	{
		header("Content-type:text/html;charset=gbk");
	}

	/*模拟登陆判断是否成功*/
	private function curl1($url,$cookie_file,$data=null){
		/*函数Curl调用*/
		$cookieFilePath=$cookie_file;
		$curl = curl_init();
		curl_setopt($curl,CURLOPT_HEADER,0);
	    curl_setopt($curl, CURLOPT_URL, $url);
	    curl_setopt($curl,CURLOPT_RETURNTRANSFER,1);

	    if (!empty($data)){
	        curl_setopt($curl, CURLOPT_POST, 1);
	        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
	    }
	    curl_setopt($curl, CURLOPT_REFERER, 'http://nic.ahnu.edu.cn/cgi-bin/service');
	    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
	    // curl_setopt($curl, CURLOPT_COOKIESESSION, true );
	    curl_setopt($curl, CURLOPT_COOKIEJAR,$cookieFilePath); //存储cookies
	    $output = curl_exec($curl);
	    curl_close($curl);
	    return $output;
	}

	public function checkuser()
	{
		//header("Content-type:text/html;charset=gbk");
		$array = array(
			'username' => 'sbsbsbsb'
			'amount' => '05.00',
			'a' => ""
			);
		$data = json_encode($array);
		$url = 'http://recharge.ahnu.edu.cn/simpleGenTrans.php';
		$result = $this->curl_request($url, $data);
		$info = json_decode($result);
		var_dump($result);
		//file_put_contents('/opt/lampp/htdocs/wechatahnu/public/write/ceshi',$info['sign']);
		var_dump($info);
	}

	private function curl_request($url, $data=null)
	{
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
		return $output;
	}
}
?>