<?php
// C:\xampp\htdocs\api\register.php

header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

// Cấu hình DB XAMPP (mặc định)
$dbHost = 'localhost';
$dbName = 'likewebapp';
$dbUser = 'root';
$dbPass = '';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed']);
    exit;
}

$input = json_decode(file_get_contents('php://input'), true);

$username = trim($input['username'] ?? '');
$email    = trim($input['email'] ?? '');
$fullName = trim($input['fullName'] ?? '');
$phone    = trim($input['phone'] ?? '');
$refCode  = trim($input['refCode'] ?? '');
$password = $input['password'] ?? '';

if ($username === '' || $password === '') {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Thiếu username hoặc password']);
    exit;
}

try {
    $dsn = "mysql:host=$dbHost;dbname=$dbName;charset=utf8mb4";
    $pdo = new PDO($dsn, $dbUser, $dbPass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    ]);

    // Kiểm tra trùng username
    $stmt = $pdo->prepare('SELECT id FROM users WHERE username = ? LIMIT 1');
    $stmt->execute([$username]);
    if ($stmt->fetch()) {
        http_response_code(409);
        echo json_encode(['success' => false, 'message' => 'Tên đăng nhập đã tồn tại']);
        exit;
    }

    $hash = password_hash($password, PASSWORD_BCRYPT);

    // Lưu user với đầy đủ thông tin
    $insert = $pdo->prepare(
        'INSERT INTO users (username, email, full_name, phone, ref_code, password_hash)
         VALUES (:username, :email, :full_name, :phone, :ref_code, :password_hash)'
    );

    $insert->execute([
        ':username'      => $username,
        ':email'         => $email ?: null,
        ':full_name'     => $fullName ?: null,
        ':phone'         => $phone ?: null,
        ':ref_code'      => $refCode ?: null,
        ':password_hash' => $hash,
    ]);

    echo json_encode(['success' => true, 'message' => 'Đăng ký thành công']);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Lỗi server', 'error' => $e->getMessage()]);
}