<?php
error_reporting(E_ALL);
ini_set('display_errors', 'On');
header("Content-Type:application/json");
require "config.php";




$json = file_get_contents('php://input');

// Converts it into a PHP object
$data = json_decode($json,true);


if(isset($data['op'])){
	$op = $data['op'];
	switch ($op) {
		case 'add_absensi':
			if(verify_request($data)){
				unset($data['op']);
				unset($data['signature']);
				$stat = insertIntoDB($conn,"absensi",$data);
				response(200,"success",$stat);
			}else{
				response(404,"not found",$data);
			}
			
			# code...
			break;
		
		default:
			response(400,"illegal request",NULL);
			break;
	}
}else{
	response(404,"not found",NULL);
}






function response($status,$status_message,$data)
{
	header("HTTP/1.1 ".$status);
	
	$response['status']=$status;
	$response['status_message']=$status_message;
	$response['data']=$data;
	
	$json_response = json_encode($response);
	echo $json_response;
}
?>