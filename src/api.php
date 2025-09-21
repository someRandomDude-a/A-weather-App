<?php
// Allow from any origin
header("Access-Control-Allow-Origin: *");

// Allow specific methods (GET, POST, etc.)
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");

// Allow specific headers (or all)
header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");

// Handle pre-flight request (OPTIONS request)
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    http_response_code(200);
    exit();
}


include 'db.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $inputData = file_get_contents('php://input');

    $data = json_decode($inputData, true);

    if (isset($data['device_token'], $data['temperature'], $data['humidity'], $data['datetime'])) {

        $deviceToken = $data['device_token'];
        $temperature = $data['temperature'];
        $humidity = $data['humidity'];
        $datetime = $data['datetime'];

        try {
            $stmt = $pdo->prepare("INSERT INTO device_data (device_token, temperature, humidity, datetime) 
                                    VALUES (:device_token, :temperature, :humidity, :datetime)");
            
            $stmt->execute([
                ':device_token' => $deviceToken,
                ':temperature' => $temperature,
                ':humidity' => $humidity,
                ':datetime' => $datetime
            ]);

            echo json_encode([
                'status' => 'success',
                'message' => 'Data inserted successfully!'
            ]);
        } catch (PDOException $e) {
            echo json_encode([
                'status' => 'error',
                'message' => 'Database error: ' . $e->getMessage()
            ]);
        }
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'Missing required fields (device_token, temperature, humidity, datetime)'
        ]);
    }

} else {
    echo json_encode([
        'status' => 'error',
        'message' => 'Only POST requests are allowed.'
    ]);
}
?>
