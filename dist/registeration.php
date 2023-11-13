<?php
header('Content-Type: application/json');

$response = array('success' => false, 'message' => 'Registration failed.');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $description = $_POST["description"];

    // Hash the password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Save user data to JSON file
    $userData = array(
        'name' => $name,
        'email' => $email,
        'password' => $hashedPassword,
        'description' => $description
    );

    $users = json_decode(file_get_contents('users.json'), true) ?: array();
    $users[] = $userData;
    file_put_contents('users.json', json_encode($users, JSON_PRETTY_PRINT));

    // Save uploaded photo with email as part of the file name
    $targetDir = 'uploads/';
    $photoFileName = $email . '_photo_' . basename($_FILES['photo']['name']);
    $targetFilePhoto = $targetDir . $photoFileName;
    move_uploaded_file($_FILES['photo']['tmp_name'], $targetFilePhoto);

    // Save uploaded resume with email as part of the file name
    $resumeFileName = $email . '_resume_' . basename($_FILES['resume']['name']);
    $targetFileResume = $targetDir . $resumeFileName;
    move_uploaded_file($_FILES['resume']['tmp_name'], $targetFileResume);

    $response['success'] = true;
    $response['message'] = 'Registration successful.';
}

echo json_encode($response);
?>
