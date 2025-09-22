<?php
error_reporting(0);
include_once 'config/dbh.php';
include_once 'config/cors.php';
include_once 'config/page-config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data = json_decode(file_get_contents("php://input"));
        
    $user_id    = $data->user_id;

    if($user_id!=''){

        //CHECK IF USER EXIST
        $sql_validation = $conection->query("SELECT COUNT(id) as userExist  FROM `eroxon_data` WHERE `id`='".$user_id."'");
        $row = $sql_validation -> fetch_assoc();        
        $user_exist =  $row['userExist'];

        if($user_exist>0){

            if($data->ans_2!=''){
                $ans_2 = $data->ans_2;
                $sql = $conection->query("UPDATE `eroxon_data` SET `ans_2`='".$ans_2."' WHERE `id`='".$user_id."'");
            } elseif($data->ans_3!=''){
                $ans_3 = $data->ans_3;
                $sql = $conection->query("UPDATE `eroxon_data` SET `ans_3`='".$ans_3."' WHERE `id`='".$user_id."'");
            } elseif($data->ans_4!=''){
                $ans_4 = $data->ans_4;
                $sql = $conection->query("UPDATE `eroxon_data` SET `ans_4`='".$ans_4."' WHERE `id`='".$user_id."'");
            } elseif($data->ans_5!=''){
                $ans_5 = $data->ans_5;
                $sql = $conection->query("UPDATE `eroxon_data` SET `ans_5`='".$ans_5."' WHERE `id`='".$user_id."'");
            } elseif($data->ans_6!=''){
                $ans_6 = $data->ans_6;
                $sql = $conection->query("UPDATE `eroxon_data` SET `ans_6`='".$ans_6."' WHERE `id`='".$user_id."'");
            }
               
            if ($sql) {
                http_response_code(200);
                echo json_encode(array('message' => 'Update Success'));
            } else {
                http_response_code(500);
                echo json_encode(array('message' => 'Internal Server error'));
            }
            
        } else {
            http_response_code(500);
            echo json_encode(array('message' => 'Bad request: the user does not exist'));
        } 
    } else {
        http_response_code(500);
        echo json_encode(array('message' => 'incomplete request'));
    }
} else {
    http_response_code(404);
}