<?php
error_reporting(0);
include_once 'config/dbh.php';
include_once 'vendor/autoload.php';
include_once 'config/cors.php';
use \Firebase\JWT\JWT;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data = json_decode(file_get_contents("php://input"));
    $edad = $data->edad;
    $utmSource = $data->utmSource;
    $utmMedium = $data->utmMedium;
    $utmCampaign = $data->utmCampaign;

    if (!empty($edad)) {
        // Preparar la inserción
        $stmt = $conection->prepare("INSERT INTO eroxon_data (edad, utm_source, utm_medium, utm_campaign, fecha) VALUES (?, ?, ?, ?, NOW())");
        $stmt->bind_param("ssss", $edad, $utmSource, $utmMedium, $utmCampaign);

        if ($stmt->execute()) {
            $id = $conection->insert_id;
            $key = "EROXONAPI";  // JWT KEY
            $payload = array(
                'id' => $id
            );
            $token = JWT::encode($payload, $key);
            http_response_code(200);
            echo json_encode(array('id' => $id, 'token' => $token));
        } else {
            http_response_code(500);
            echo json_encode(array('message' => 'Failed to insert data'));
        }

        $stmt->close();
    } else {
        http_response_code(400);
        echo json_encode(array('message' => 'Invalid input: edad is required'));
    }
} else {
    http_response_code(405);
    echo json_encode(array('message' => 'Method Not Allowed'));
}
?>
