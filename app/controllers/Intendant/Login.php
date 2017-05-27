<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
    }


   // public function new()
   // {
     //   $url = 'https://api.weixin.qq.com/cgi-bin/message/mass/send?access_token=ACCESS_TOKEN';
   // }
    /*待解决问题*/
    // 1、不是管理员扫码有问题117行
    // 2、扫码一次过后再扫码会出现什么问题103行

    public function index() {
        /*生成二维码*/
        /*先在数据库中找有没有status为3的二维码，3表示已经登录成功过。*/
        $data = $this->db->where('status','3')->get('login_status');
        $result = '';
        if (!$data->num_rows()) {//已过期的状态1
            // echo '1';
            $time = time()-1800;
            $data = $this->db->where('status',1)
                ->where('time <', $time)
                ->get('login_status');
            if ($data->num_rows()) {
                $result = $data->result_array()[0];
            } else {//已过期的状态2
                // echo '2';
                $data = $this->db->where('status',2)
                ->where('time <', $time)
                ->get('login_status');
                if ($data->num_rows()) {
                    // echo '3';
                    $result = $data->result_array()[0];
                }
            }
        } else {
            $result = $data->result_array()[0]; 
        }

        if (!$result) {
            /*生成新的二维码*/
            $this->load->helper('string');
            $state = date('YmdHis').random_string('alnum', 8);

            include_once "public/php/phpqrcode/phpqrcode.php";
            //二维码内容 
            $value = 'http://wechat.yaocloud.cn/Intendant/login/oauth2url?state='.$state;
            $qr_eclevel = 'H';//容错级别 
            $picsize = 4;//生成图片大小
            QRcode::png($value, 'public/admin/images/login_qrcode/'.$state.'.png', $qr_eclevel, $picsize);//生成二维码图

            /*然后将这个数据存入数据库*/
            $insert = array(
                'name' => $state.'.png',
                'time' => time()
            );
            $this->db->insert('login_status',$insert);
            $id= $this->db->insert_id();
            $result = array(
                'id' => $id,
                'name' => $state.'.png'
            );
        } else {
            //如果由result要把这条记录的时间戳更新
            $update = array(
                'time' => time()
            );
            $this->db->where('id',$result['id'])->update('login_status',$update);

            $state = $result['name'].substr(0,-4);
        }
        $data = get_global();
        $assign = array(
            'site_name'=>$data['site_name'],
            'qrcode' => $result,
            'state' => $state
        );
        $this->load->view('intendant/login',$assign);
    }

    public function getCode()
    {
        $state = $this->input->get('state');
        // $state = isset($_GET['state'])?$_GET['state']:'201704181258106cOF8d03.png';
        //state其实就是图片名称
        /*通过code,获取access_token和code*/
        $code = $this->input->get('code');
        $url = 'https://api.weixin.qq.com/sns/oauth2/access_token?appid='.APPID.'&secret='.APPSECRET.'&code='.$code.'&grant_type=authorization_code';
        $data = https_request($url);
        $access_token = $data['access_token'];
        $openid = $data['openid'];
        // $openid = 'oild4wHv3pTetKtuaI28ylHO3fIM';

        /*查看openid在后台数据库里面是否有*/
        $count = $this->db
            ->where('openid', $openid)
            ->where('status', 1) 
            ->count_all_results('user');

        if ($count == 1) {
            // 及时有数据也要判断这个码是否扫过了。
                $data = get_global();
                $assign = array(
                    'site_name'=>$data['site_name'],
                    'site_url'=>$data['site_url'],
                    'footer_text'=>$data['footer_text'],
                    'openid'=>$openid,
                    'state'=>$state
                );
                $this->load->view('intendant/login_confirm',$assign);
            // } else {
            //     exit('系统错误，请联系管理员');
            // }
        } else {
            $this->load->view('intendant/login_error',$assign);
        }
    }

    /*PC不断请求是否已经扫码确认登录*/
    public function is_login($state)
    {
        echo $state;
        $name = $state.'.png';
        $data = $this->db
            ->where('name', $name)
            ->where('status', 2)
            ->select('status')
            ->get('login_status')
            ->num_rows();
            var_dump($data);
            $sql = $this->db->get_compiled_select('login_status');
            echo $sql;
            exit;
            // ->row_array();

            // exit;
            // // ->result_array();
        if( $data == '1' ){
            echo '1';
        } else {
            echo '0';
        }
        // echo json_encode(array('is_login'=>'0'));
    }

    /*移动端已点击确认登录*/
    public function confirm()
    {
        $state = $this->input->post('state');
        $openid= $this->input->post('openid');

        $time = time()-1800;
        $status = $this->db->where('name', $state)
            ->where('time >', $time)
            ->select('id')
            ->get('login_status');
        if (!($status->num_rows())) {
            /*找不到说明二维码失效*/
            $response['msg'] = '对不起，二维码已失效';
            $response['error'] = '1';
            echo json_encode($response);
            exit;
        } else {
            /*说明找到了*/
            $status = $status->row_array();
            $update = array(
                'login_status_id' => $status['id']
                );
            $this->db->where('openid',$openid)
                ->update('user',$update);

            $update = array(
                'status' => '2'
                );
            $this->db->where('name', $state)
                ->update('login_status',$update);

            $response['msg'] = '登录成功';
            $response['error'] = '0';  
            echo json_encode($response);
            exit; 
        }

       echo json_encode(array('error'=>'0'));
    }

    public function login_confirm()
    {
        $data = get_global();
        $assign = array(
            'site_name'=>$data['site_name'],
            'site_url'=>$data['site_url'],
            'footer_text'=>$data['footer_text'],
            'openid'=>'openid'
        );
        $this->load->view('intendant/login_confirm',$assign);
    }

    public function login_error()
    {
        $data = get_global();
        $assign = array(
            'site_name'=>$data['site_name'],
            'site_url'=>$data['site_url'],
            'footer_text'=>$data['footer_text'],
            'openid'=>'openid'
        );
        $this->load->view('intendant/login_error',$assign);
    }

    public function phpqrcode() 
    {
        include_once "public/php/phpqrcode/phpqrcode.php";
        $value = 'https://open.weixin.qq.com/connect/oauth2/authorize?appid=wx83580994547f31e0&redirect_uri=http%3A%2F%2Fwechat.yaocloud.cn%2FIntendant%2Flogin%2FgetCode&response_type=code&scope=snsapi_userinfo&state=3#wechat_redirect'; //二维码内容 
        $qr_eclevel = 'H';//容错级别 
        $picsize = 4;//生成图片大小
        QRcode::png($value, false, $qr_eclevel, $picsize);//生成二维码图
    }
    // function index2()
    // {
    //     $this->load->library('migration');

    //     $this->migration->latest();
    //     echo APPPATH;
    //     exit;
    // 	/*微信登录*/
    //     echo $_SERVER['DOCUMENT_ROOT'].'/public/write/access_token.php';
    //     // exit;
    // 	$data = get_access_token();
    // 	var_dump($data);
    //     exit;
    // 	$json = '{
    // 		"expire_seconds": 3600, 
    // 		"action_name": "QR_SCENE", 
    // 		"action_info": {
    // 			"scene": {
    // 				"scene_id": 123
    // 			}
    // 		} 
    // 	}';
    // 	// $data = https_request('https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token='.$data['access_token'],$json);
    // 	// var_dump($data);
    // 	// $ticket = $data['ticket'];
    // 	$ticket = 'gQGh7zwAAAAAAAAAAS5odHRwOi8vd2VpeGluLnFxLmNvbS9xLzAyVmNmem9xYW5kVTAxVEp4czFvMUoAAgTdU9xYAwQQDgAA';
    // 	echo $ticket;
    // 	$url = 'https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket='.urlencode($ticket);
    // 	$imageInfo = $this->downloadImageFromWeiXin($url);

    // 	$filename = 'qrcode.jpg';
    // 	$local_file = fopen($filename, 'w');
    // 	if(false !== $local_file){
    // 		if(false !== fwrite($local_file, $imageInfo['body']))
    // 			fclose($local_file);
    // 	}
    // 	// $data = https_request($url);
    // 	// var_dump($data);
    //     // $this->load->view('intendant/login');
    //     /*建数据库将这个地址保存，并存储他的有效时间和对应的参数*/
    // }

    public function oauth2url()
    {
        $value = 'https://open.weixin.qq.com/connect/oauth2/authorize?appid=wx83580994547f31e0&redirect_uri=http%3A%2F%2Fwechat.yaocloud.cn%2FIntendant%2Flogin%2FgetCode&response_type=code&scope=snsapi_userinfo&state='.$this->input->get('state').'.png#wechat_redirect';
        redirect($value);
    }

    private function downloadImageFromWeiXin($url)
    {
    	$curl = curl_init($url);
		curl_setopt($curl, CURLOPT_HEADER, 0);
		curl_setopt($curl, CURLOPT_NOBODY, 0);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		$package = curl_exec($curl);
		$httpinfo = curl_getinfo($curl);
		curl_close($curl);
		return array_merge(array('body' => $package), array('header' => $httpinfo));
    }
}
