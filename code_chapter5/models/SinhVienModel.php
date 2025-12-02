<?php
// Tệp Model sẽ chứa tất cả logic truy vấn CSDL 

// TODO 1: Viết 1 hàm tên là getAllSinhVien() 
function getAllSinhVien($pdo)
{
    $sql = "SELECT * FROM sinhvien ORDER BY ngay_tao DESC";
    $stmt = $pdo->query($sql);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


// TODO 2: Viết 1 hàm tên là addSinhVien() 
function addSinhVien($pdo, $ten, $email)
{
    $sql = "INSERT INTO sinhvien (ten_sinh_vien, email) VALUES (?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$ten, $email]);
}