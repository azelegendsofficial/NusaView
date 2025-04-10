// /api/store-user.php
<?php
header('Content-Type: application/json');

// Get the raw POST data
$jsonData = file_get_contents('php://input');
$userData = json_decode($jsonData, true);

// Database connection
$servername = "localhost";
$username = "your_db_username";
$password = "your_db_password";
$dbname = "your_database";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    http_response_code(500);
    echo json_encode(['error' => 'Database connection failed']);
    exit;
}

// Prepare and execute SQL statement
$stmt = $conn->prepare("INSERT INTO oauth_users (provider_id, provider_name, name, email, profile_picture, access_token) 
                       VALUES (?, ?, ?, ?, ?, ?) 
                       ON DUPLICATE KEY UPDATE 
                       name = VALUES(name), 
                       email = VALUES(email), 
                       profile_picture = VALUES(profile_picture), 
                       access_token = VALUES(access_token)");

$stmt->bind_param("ssssss", 
    $userData['id'],
    $userData['provider'],
    $userData['name'],
    $userData['email'],
    $userData['profilePicture'],
    $userData['accessToken']
);

if ($stmt->execute()) {
    // Get the user ID
    $userId = $stmt->insert_id;
    if ($userId == 0) {
        // This was an update, get the user ID
        $getIdStmt = $conn->prepare("SELECT id FROM oauth_users WHERE provider_id = ? AND provider_name = ?");
        $getIdStmt->bind_param("ss", $userData['id'], $userData['provider']);
        $getIdStmt->execute();
        $result = $getIdStmt->get_result();
        $row = $result->fetch_assoc();
        $userId = $row['id'];
        $getIdStmt->close();
    }
    
    // Set session variables
    session_start();
    $_SESSION['user_id'] = $userId;
    $_SESSION['user_name'] = $userData['name'];
    $_SESSION['user_provider'] = $userData['provider'];
    
    echo json_encode(['success' => true, 'user_id' => $userId]);
} else {
    http_response_code(500);
    echo json_encode(['error' => 'Database error: ' . $stmt->error]);
}

$stmt->close();
$conn->close();
?>
