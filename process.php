<?php
require_once 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $student_id = $_POST['student_id'];
    $name = $_POST['name'];
    $department = $_POST['department'];
    $category = $_POST['category'];
    $content = $_POST['content'];

    // 학생 정보 저장 또는 업데이트
    $stmt = $conn->prepare("INSERT INTO students (student_id, name, department) VALUES (?, ?, ?) 
                           ON DUPLICATE KEY UPDATE name = ?, department = ?");
    $stmt->bind_param("sssss", $student_id, $name, $department, $name, $department);
    $stmt->execute();
    $student_db_id = $stmt->insert_id ?: $conn->insert_id;

    // 상담 기록 저장
    $stmt = $conn->prepare("INSERT INTO counseling_records (student_id, category, content) VALUES (?, ?, ?)");
    $stmt->bind_param("iss", $student_db_id, $category, $content);
    
    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => '상담 기록이 저장되었습니다.']);
    } else {
        echo json_encode(['success' => false, 'message' => '오류가 발생했습니다.']);
    }
    
    $stmt->close();
    $conn->close();
}
?> 