<?php
include_once 'vendor/autoload.php';
use \Firebase\JWT\JWT;
//include_once 'config/cors.php';





function autenticationaccesstoken($t){
    // get request headers
    $data_obj= array();
$authHeader = getallheaders();
if (isset($t)) {
    $token = $t;
    $token = explode(" ", $token)[0];

    try {
        $key = "EROXONAPI";
        $decoded = JWT::decode($token, $key, array('HS256'));

        // Do some actions if token decoded successfully.

        // But for this demo let return decoded data
        $data_obj=$decoded;
        //echo json_encode($decoded);
    } catch (Exception $e) {
        
        //echo json_encode(array('message' => 'Please authenticate2'));
        $data_obj=array('message' => 'Please authenticate','code'=>400);
    }
} else {
    
    //echo json_encode(array('message' => 'Please authenticate1'));
        $data_obj=array('message' => 'Please authenticate','code'=>500);
}
    return $data_obj;
}

?>