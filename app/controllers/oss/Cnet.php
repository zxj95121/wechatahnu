<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cnet extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
	}
	
	public function index()
	{
		header("Content-type:text/html;charset=gbk");
		// $data=array(
		// 	'username'=>'zxj95121',
		// 	'password'=>'026006',
		// 	'reffer'=>'http://www.ahnu.edu.cn/'
		// );

		// $cookie_file=tempnam('./tmp','cookie');//tmp目录需要先建立好

		// if(0){
			// $url='http://jwgl.ahnu.edu.cn/login/check.shtml';
			// $data=$this->curl1($url,$cookie_file,$data);
			// return json_decode($data);
		// }
		// else{
		// 	$url='http://nic.ahnu.edu.cn/cgi-bin/service';
		// 	$data=$this->curl1($url,$cookie_file,$data);//先模拟登陆进入
		// 	var_dump($data);
			//再变更请求
			// $url='http://jwgl.ahnu.edu.cn/query/cjquery?action=ok&xkxn='.$xkxn.'&xkxq='.$xkxq;
			// $url='http://nic.ahnu.edu.cn/cgi-bin/service';
			// $data=$this->curl2($url,$cookie_file,$data);
			// var_dump($data);
		// }
		// header("Content-type:text/html;charset=gbk");
		$url = 'http://oss.ahnu.edu.cn/blueoss/cnet/api_editPassword.php?account=lantian&secret=kaiyuan';
		$data = array(
			'username' => 'zxj95121',
			'password' => '026005',
			'password1' => '026006'
			);
		$data = json_encode($data);

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
		var_dump($output);
	}

	public function cnet()
	{
		return redirect(httpd('/oss/cnet/oauth2'));
	}

	public function oauth2()
	{
		$url = 'https://open.weixin.qq.com/connect/oauth2/authorize?appid='.APPID.'&redirect_uri='.urlencode(httpd('/oss/cnet/getCode')).'&response_type=code&scope=snsapi_userinfo&state=1#wechat_redirect';
		return redirect($url);
	}

	public function getCode()
	{
		$code = $this->input->get('code');
		$url = 'https://api.weixin.qq.com/sns/oauth2/access_token?appid='.APPID.'&secret='.APPSECRET.'&code='.$code.'&grant_type=authorization_code';
		$data = https_request($url);
		// var_dump($data);
		// var_dump($code);

		if (!isset($data['errcode'])) {
			$openid = $data['openid'];
			$access_token = $data['access_token'];

			/*再根据access_token获取用户信息*/
			$url = 'https://api.weixin.qq.com/sns/userinfo?access_token='.$access_token.'&openid='.$openid.'&lang=zh_CN';
			$userinfo = https_request($url);
			if (!isset($userinfo['errcode'])) {
				// var_dump($userinfo);
				/*判断有没有这个用户openid数据库中*/
				$db = $this->db->where('openid', $openid)
					->where('status', '1')
					->select('id')
					->get('cnet_user');
				$num = $db->num_rows();

				if ($num == 0) {
					// 解析binding,进行绑定
					// return redirect(httpd('/oss/cnet/binding'));
					// $assign = array(
					// 	'openid' => $openid,
					// 	'headimgurl' => $userinfo['headimgurl']
					// 	);

					echo "<form style='display:none;' id='form1' name='form1' method='post' action='".httpd('/oss/cnet/binding')."'>
              <input name='openid' type='text' value='".$openid."' />
              <input name='headimgurl' type='text' value='".$userinfo['headimgurl']."'/>
              <input name='nickname' type='text' value='".$userinfo['nickname']."'/>
            </form>
            <script type='text/javascript'>document.form1.submit();</script>";
					// $this->load->view('oss/cnet/binding',$assign);
				} else {
					$id = $db->row_array()['id'];
					$this->session->set_userdata('id', $id);
					$this->session->set_userdata('openid', $openid);
					return redirect(httpd('/oss/cnet/show?nickname='.$userinfo['nickname'].'?headimgurl='.$userinfo['headimgurl']));
				}
			}
		}
	}

	public function binding()
	{
		if (!isset($_POST['openid'])) {
			exit('错误原因：没有收到值，请联系管理员');
		}
		$openid = $this->input->post('openid');
		$headimgurl = $this->input->post('headimgurl');
		$nickname = $this->input->post('nickname');
		// var_dump($this->input->post());exit;
		$assign = array(
			'openid' => $openid,
			'headimgurl' => $headimgurl,
			'nickname' => $nickname
			);
		$this->load->view('oss/cnet/binding', $assign);
	}

	/*验证用户名是否已经绑定*/
	public function valid_number()
	{
		$username = $this->input->post('username');
		$num = $this->db->where('username', $username)
			->where('status', '1')
			->select('id')
			->get('cnet_user')
			->num_rows();
		if ($num == 0) {
			echo json_encode(array('error'=>'0'));
		} else {
			echo json_encode(array('error'=>'1'));
		}
	}

	public function valid_bind()
	{
		$this->load->library('encryption');
		$username = $this->input->post('username');
		$password = $this->input->post('password');
		$openid = $this->input->post('openid');
		/*请求开源服务器，判断该账户密码是否符合*/
		$url = 'http://oss.ahnu.edu.cn/blueoss/cnet/api_identify.php?account=lantian&secret=kaiyuan';
		$data = array(
			'username' => $username,
			'password' => $password 
			);
		$data = json_encode($data);
		$result = https_request($url, $data);
		// var_dump($result);
		if (isset($result['result']) && $result['result'] == '1') {
			/*一切OK，进行数据库存储*/
			$insert = array(
				'openid' => $openid,
				'username' => $username,
				'password' => $this->encryption->encrypt($password)
				);
			$this->db->insert('cnet_user', $insert);
			/*建立session id*/
			$id = $this->db->insert_id();
			$this->session->set_userdata('id', $id);

			echo json_encode(array('error'=>'0'));
		} else {
			echo json_encode(array('error'=>'1'));
		}
	}

	/*重新绑定密码*/
	public function valid_rebind()
	{
		$this->load->library('encryption');
		$username = $this->input->post('username');
		$password = $this->input->post('password');
		$openid = $this->input->post('openid');
		/*请求开源服务器，判断该账户密码是否符合*/
		$url = 'http://oss.ahnu.edu.cn/blueoss/cnet/api_identify.php?account=lantian&secret=kaiyuan';
		$data = array(
			'username' => $username,
			'password' => $password 
			);
		$data = json_encode($data);
		$result = https_request($url, $data);
		// var_dump($result);
		if (isset($result['result']) && $result['result'] == '1') {
			/*一切OK，进行数据库存储*/
			$update = array(
				'password' => $this->encryption->encrypt($password)
				);
			$this->db->where('openid', $openid)
				->update('cnet_user', $update);
			/*建立session id*/
			$id = $this->db->where('openid',$openid)
				->select('id')
				->get('cnet_user')
				->row_array()['id'];
			$this->session->set_userdata('id', $id);
			$this->session->set_userdata('openid', $openid);

			echo json_encode(array('error'=>'0'));
		} else {
			echo json_encode(array('error'=>'1'));
		}
	}

	/*详情展示页*/
	public function show()
	{
		// header("Content-type:text/html;charset=utf-8");
		$this->load->library('encryption');
		// 查id
		if (!$this->session->userdata('id')) {
			exit('不知道是谁在访问');
		}

		$id = $this->session->userdata('id');
		$data = $this->db->where('id', $id)
			->where('status', '1')
			->select('username, password, openid')
			->get('cnet_user')
			->row_array();

		$data['password'] = $this->encryption->decrypt($data['password']);

		$json=json_encode(array(
			'username' => $data['username'],
			'password' => $data['password']
			));

		/*调用api2接口，查到校园网信息*/
		$url = 'http://oss.ahnu.edu.cn/blueoss/cnet/api_getMessage.php?account=lantian&secret=kaiyuan';
		$result = https_request($url, $json);
		$result['nickname'] = $this->input->get('nickname');
		$result['openid'] = $data['openid'];
		if ($result['errcode'] == 0) {
			/*查成功*/
			$result['openid'] = $data['openid'];
			$result['headimgurl'] = $this->input->get('headimgurl');
			$this->load->view('oss/cnet/show', $result);
		} else {
			/*查失败了，跳到提醒页面*/
			$assign = array(
				'openid' => $data['openid']
				);
			$this->load->view('oss/cnet/show_errpass', $assign);
		}
	}

	public function rebinding()
	{
		$this->load->library('encryption');
		$openid = $this->session->userdata('openid');
		$data = $this->db->where('openid', $openid)
			->where('status', '1')
			->select('username, password, openid')
			->get('cnet_user')
			->row_array();

		/*unionID获取用户头像信息*/
		$access_token = get_access_token()['access_token'];
		$url = 'https://api.weixin.qq.com/cgi-bin/user/info?access_token='.$access_token.'&openid='.$openid.'&lang=zh_CN';
		$userinfo = https_request($url);
		// var_dump($userinfo);
		$headimgurl = $userinfo['headimgurl'];
		$nickname = $userinfo['nickname'];

		$assign = array(
			'username' => $data['username'],
			'openid' => $openid,
			'headimgurl' => $headimgurl,
			'nickname' => $nickname
			);

		$this->load->view('oss/cnet/rebinding.php', $assign);
	}

	/*修改校园网密码*/
	public function editPassword()
	{
		$this->load->library('encryption');
		$openid = $this->input->post('openid');
		$password1 = $this->input->post('password1');
		$password2 = $this->input->post('password2');
		/*查时间修改密码时间是否为一天内*/
		$time = date('Ymd');
		$data = $this->db->where('openid', $openid)
			->select('ep_time, password, username')
			->get('cnet_user')
			->row_array();
		$ep_time = date('Ymd',$data['ep_time']);
		$password = $this->encryption->decrypt($data['password']);
		if ($password == $password1) {
			echo json_encode(array('error'=>'1','reason'=>'修改失败，新密码与旧密码相同'));
			exit;
		}
		if ($ep_time == $time) {
			echo json_encode(array('error'=>'1','reason'=>'修改失败，一天只能修改一次'));
			exit;
		} else {
			/*请求服务器接口*/
			$data = array(
				'username' => $data['username'],
				'password' => $password,
				'password1' => $password1
				);
			$data = json_encode($data);
			$url = 'http://oss.ahnu.edu.cn/blueoss/cnet/api_editPassword.php?account=lantian&secret=kaiyuan';
			// $result = https_request($url);
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
			// var_dump($output);
			$result = json_decode($output, true);

			// var_dump($result['result']);
			if ($result['errcode'] == '1') {
				echo json_encode(array('error'=>'2','reason'=>'系统匹配的原密码不正确，请联系管理员。'));
				exit;
			// } else if (strpos('\u6210\u529f\u66f4\u6539\u5bc6\u7801!',$result['result']) !== false || strpos(iconv('utf-8','gbk','成功更改密码!'),$result['result']) !== false) {
			} else if ($result['result'] == '1') {
				$time = time();
				$password = $this->encryption->encrypt($password1);
				$update = array(
					'ep_time' => $time,
					'password' => $password
					);
				$this->db->where('openid', $openid)
					->update('cnet_user', $update);
				echo json_encode(array('error'=>'0','reason'=>'修改成功'));
				exit;
			} else {
				echo json_encode(array('error'=>'1','reason'=>'修改失败，可能是密码过于简单，可重试。如有问题请联系管理员。'));
				exit;
			}
		}
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

	// private function curl2($url,$cookie_file,$data=null){
	// 	/*函数Curl调用*/
	// 	$cookieFilePath=$cookie_file;
	// 	$curl = curl_init();
	//     curl_setopt($curl, CURLOPT_URL, $url);
	//     curl_setopt($curl, CURLOPT_HEADER, 0);
	//     curl_setopt($curl, CURLOPT_REFERER, 'http://nic.ahnu.edu.cn/cgi-bin/service');
	//     if (!empty($data)){
	//         curl_setopt($curl, CURLOPT_POST, 1);
	//         curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
	//     }
	//     curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
	//     curl_setopt($curl, CURLOPT_COOKIEFILE, $cookieFilePath);
	//     $output = curl_exec($curl);
	//     curl_close($curl);
	//     return $output;
	// }
	public function checkuser()
	{
		// header("Content-type:text/html;charset=gbk");
		$array = array(
			'username' => 'zxj95121',
			'amount' => '05.00',
			'a' => ""
			);
		$data = json_encode($array);
		// var_dump($data);
		$url = 'http://recharge.ahnu.edu.cn/simpleGenTrans.php';
		$result = trim($this->curl_request($url, $data),"\xEF\xBB\xBF");
		// echo $result.'<br />';
		$data = json_decode($result);

		$url = 'http://zfpt.ahnu.edu.cn/zhifu/payAccept.aspx';
		$data = array(
			);
		var_dump($result);
		var_dump($data);
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
