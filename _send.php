<?php 
define("SMS_GATEWAY_EMAIL", 'info@breezesoft.uz'); 
define("SMS_GATEWAY_SECRET", 'DVrQ0IH9wS6tOCXAAZzPnKLT6kOU2uLPkiIwjwMW'); 
define("SMS_GATEWAY_URL", 'https://notify.eskiz.uz/api/'); 
define('SMS_GATEWAY_TOKEN_FILE', $_SERVER['DOCUMENT_ROOT'].'/sms_gateway_token.json');

define('SMS_GATEWAY_TOKEN', file_get_contents(SMS_GATEWAY_TOKEN_FILE));
class Eskiz{
    private $token = '';
	function __construct($email = '', $secret = ''){
		
		if($email != '' ANd $secret != ''){
			$smsdata = [
				'email' => $email,
				'password' => $secret
			];

		}else{
			$smsdata = [
				'email' => SMS_GATEWAY_EMAIL,
				'password' => SMS_GATEWAY_SECRET
			];
		}
		if(SMS_GATEWAY_TOKEN == ''){
			$sms_gateway_data = json_decode($this->sendPing($smsdata, 'auth/login', 'oauth'), 1);
			if($sms_gateway_data['message'] == 'token_generated'){
				file_put_contents(SMS_GATEWAY_TOKEN_FILE, $sms_gateway_data['data']['token']);
			}
			$token = $sms_gateway_data['data']['token'];
		}else{
			
			$token = file_get_contents(SMS_GATEWAY_TOKEN_FILE, $sms_gateway_data['data']['token']);
			
			$data = $this->sendPing([], 'auth/user');
			if($data['message'] != 'authenticated_user' and $data['data']['status'] !== 'active'){
				$data = $this->sendPing([], 'auth/refresh', 'PATCH');
				
			}
		}

		$this->token = $token;
	}
	function getToken(array $data) { 

		$output = $this->sendPing($data, 'auth/login', 'oauth');  
		if($output['message'] === 'token_generated'){
			$output = $output['data']['token'];
		}
		return $output;
	}
	
	function sendSMS(array $data) { 

		$output = $this->sendPing($data, 'message/sms/send');
		$output['is_sent'] = 'no';
		if($output['status'] == 'waiting'){
			$output['is_sent'] = 'yes';			
		}
		
		return $output;
	}
	
	function getSMS(integer $sms_id ) { 

		$output = $this->sendPing([], 'message/sms/get/status/' . $sms_id);
		if($output['status'] === 'success' AND $output['message']['status'] === 'Delivered'  ){
			$output = $output['message']['status'];
		}
		return $output;
	}
	
	function sendPing($content, $method, $type = '') { 

		
			$curl = curl_init(); 
			curl_setopt($curl, CURLOPT_URL, SMS_GATEWAY_URL.$method); 
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); 
            
			if($type == 'PATCH'){
				curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'PATCH');
			}

			
			if($type !== 'oauth'){
				$headers = array(
					sprintf('Authorization: Bearer %s', $this->token)
				);
				curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
			}
            
			if(!empty($content)){
				curl_setopt($curl, CURLOPT_POST, 1);
			
				curl_setopt($curl, CURLOPT_POSTFIELDS, $content);
			}
			
			$output = curl_exec($curl); 

			curl_close($curl);      
		return json_decode($output, true);
	}
}


$gateway = new eskiz(); 
	
	
	/*print_r($response);*/


