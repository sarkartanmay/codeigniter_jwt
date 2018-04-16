<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';
class App extends REST_Controller {
	/**
	 * URL: http://localhost/codeigniter_jwt/index.php/app/login
	 * Method: POST
	 * Body Key: email
	 * Value: DB saved email id
	 * Body Key: password
	 * Value: DB saved password
	 */
	public function login_post()
	{
		$data['email'] = $this->input->post("email");
		$data['pwd'] = $this->input->post("password");
		$this->load->model('user');
		if(!isset($data['email']) || !isset($data['pwd']) || strlen($data['email']) == 0  || strlen($data['pwd']) == 0 ) {
			$err['status'] = "false";
			$err1['message'] = "Invalid Parameter";
			$err['error'] = $err1;
			$this->set_response($err, REST_Controller::HTTP_UNAUTHORIZED);
		}else{
			$data['result'] = $this->user->loginCheck($data);
			if(count($data['result'])==1){
				$tokenData = array();
				foreach ($data['result']as $row)
				{
					$tokenData['fname']= $row->first_name;
					$tokenData['lname']= $row->last_name;
					$tokenData['typ']= $row->user_typ;
				}
				$tokenData['email']=$data['email'];
				$tokenData['timestamp'] = now();
				$output['token'] = AUTHORIZATION::generateToken($tokenData);
				$this->set_response($output, REST_Controller::HTTP_OK);
			}else{
				$err['status'] = "false";
				$err1['message'] = "Invalid Credential";
				$err['error'] = $err1;
				$this->set_response($err, REST_Controller::HTTP_UNAUTHORIZED);
			}
		}
	}
	/**
	 * URL: http://localhost/codeigniter_jwt/index.php/app/token
	 * Method: POST
	 * Header Key: Authorization
	 * Value: Auth token generated in POST call of 'login'
	 */
	public function token_post()
	{
		$headers = $this->input->request_headers();
		if(array_key_exists('Authorization', $headers) && !empty($headers['Authorization'])) {
			//TODO: Change 'token_timeout' in application\config\jwt.php
			$decodedToken = AUTHORIZATION::validateTimestamp($headers['Authorization']);
			// return response if token is valid
			if($decodedToken != false) {
				$res['status'] = "true";
				$res['header'] = $decodedToken;
				$this->set_response($res, REST_Controller::HTTP_OK);
			}else{
				$err['status'] = "false";
				$err1['message'] = "Token Expired";
				$err['error'] = $err1;
				$this->set_response($err, REST_Controller::HTTP_UNAUTHORIZED);
			}
		}else{
			$err['status'] = "false";
			$err1['message'] = "Token Not Found";
			$err['error'] = $err1;
			$this->set_response($err, REST_Controller::HTTP_UNAUTHORIZED);
		}
	}

	public function fruit_post()
	{
		$headers = $this->input->request_headers();
		if(array_key_exists('Authorization', $headers) && !empty($headers['Authorization'])) {
			$decodedToken = AUTHORIZATION::validateTimestamp($headers['Authorization']);
			if($decodedToken != false) {
				$res['status'] = "true";
				$res['header'] = $decodedToken;
				//--------------------------------------------------
				$this->load->model('fruit');
				$data['result'] = $this->fruit->getallfruit();
				if(count($data['result'])>=1){
					$frt = array();
					$i=0;
					foreach ($data['result']as $row)
					{
						$frt[$i]['fid']= $row->fruit_id;
						$frt[$i]['name']= $row->name;
						$i++;
					}
					$res['fruit'] = $frt;
				}
				$this->set_response($res, REST_Controller::HTTP_OK);
				//--------------------------------------------------
				$this->set_response($res, REST_Controller::HTTP_OK);
			}else{
				$err['status'] = "false";
				$err1['message'] = "Token Expired";
				$err['error'] = $err1;
				$this->set_response($err, REST_Controller::HTTP_UNAUTHORIZED);
			}
		}else{
			$err['status'] = "false";
			$err1['message'] = "Token Not Found";
			$err['error'] = $err1;
			$this->set_response($err, REST_Controller::HTTP_UNAUTHORIZED);
		}
	}

	public function newfruit_post()
	{
		$headers = $this->input->request_headers();
		if(array_key_exists('Authorization', $headers) && !empty($headers['Authorization'])) {
			$decodedToken = AUTHORIZATION::validateTimestamp($headers['Authorization']);
			if($decodedToken != false) {
				$res['status'] = "true";
				$res['header'] = $decodedToken;
				//--------------------------------------------------
				$data['name']=$this->input->post("name");
				$this->load->model('fruit');
				$data['result'] = $this->fruit->newfruit($data);
				$res['response'] = $data['result'];
				//--------------------------------------------------
				$this->set_response($res, REST_Controller::HTTP_OK);
			}else{
				$err['status'] = "false";
				$err1['message'] = "Token Expired";
				$err['error'] = $err1;
				$this->set_response($err, REST_Controller::HTTP_UNAUTHORIZED);
			}
		}else{
			$err['status'] = "false";
			$err1['message'] = "Token Not Found";
			$err['error'] = $err1;
			$this->set_response($err, REST_Controller::HTTP_UNAUTHORIZED);
		}
	}
}
