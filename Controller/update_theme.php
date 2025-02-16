<?php
session_start();

// Get the raw POST data
$data = json_decode(file_get_contents("php://input"), true);

// Check if 'theme' is received in the request
if (isset($data['theme'])) {
    $_SESSION['theme'] = $data['theme']; // Set the theme in the session
    echo json_encode(['status' => 'success', 'theme' => $_SESSION['theme']]); // Return a JSON response
} else {
    echo json_encode(['status' => 'error', 'message' => 'No theme data provided']);
}
?>