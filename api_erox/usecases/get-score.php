<?php
include_once 'config/dbh.php';
include_once 'config/cors.php';
include_once 'config/page-config.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            
    if (isset($user_id) && $user_id>0){

        //CHECK IF USER EXIST
        $sql_validation = $conection->query("SELECT COUNT(id) as userExist  FROM `eroxon_data` WHERE `id`='".$user_id."' ");
        $row1 = $sql_validation -> fetch_assoc();        
        $user_exist =  $row1['userExist'];

        if($user_exist>0){
            $sql = $conection->query("SELECT (ans_2 + ans_3 + ans_4 + ans_5 + ans_6) AS total_score FROM `eroxon_data` WHERE `id` = '$user_id'");

            if ($sql) {

                $row = $sql->fetch_assoc();
                $totalScore = $row['total_score'];

                http_response_code(200);        
                echo json_encode(array('message' => 'Success', 'totalScore' => $totalScore));
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
            echo json_encode(array('message' => 'Incomplete request' ));
    } 

} else {
    http_response_code(404);
}