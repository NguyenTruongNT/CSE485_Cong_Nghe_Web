<?php
session_start();
require 'data.php';

$success = $_GET['success'] ?? "";

if (isset($_SESSION['new_do_an'])) {
    themDoAnMoi($_SESSION['new_do_an']);
    unset($_SESSION['new_do_an']);
}
?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Dashboard Quản lý Đồ Án</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container mt-2 mb-3">
            <span class="navbar-brand fw-bold">
                QUẢN LÝ ĐỒ ÁN TỐT NGHIỆP
            </span>
            <div>
                <a href="index.php" class="btn btn-outline-light me-2">Dashboard</a>
                <a href="create.php" class="btn btn-primary">+ Thêm đồ án</a>
            </div>
        </div>
    </nav>

    <div class="container mt-4 mb-5">

        <h2 class="mb-3">Danh sách Đồ Án</h2>
        <p class="text-muted">Dữ liệu này chỉ đang được lưu trong mảng PHP mô phỏng cơ sở dữ liệu.</p>

        <?php if ($success == "created"): ?>
            <div class="alert alert-success">
                Thêm đồ án mới thành công.
            </div>
        <?php endif; ?>

        <div class="card shadow mt-3">
            <div class="card-body">

                <table class="table table-bordered table-striped">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Tên đề tài</th>
                            <th>Sinh viên</th>
                            <th>Mã sinh viên</th>
                            <th>Giảng viên hướng dẫn</th>
                            <th>Năm học</th>
                            <th>Trạng thái</th>
                            <th>Ngày tạo</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php if (!empty($do_an_list)): ?>
                            <?php foreach ($do_an_list as $do_an): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($do_an['id']); ?></td>
                                    <td><?php echo htmlspecialchars($do_an['ten_de_tai']); ?></td>
                                    <td><?php echo htmlspecialchars($do_an['ten_sinh_vien']); ?></td>
                                    <td><?php echo htmlspecialchars($do_an['mssv']); ?></td>
                                    <td><?php echo htmlspecialchars($do_an['giang_vien_hd']); ?></td>
                                    <td><?php echo htmlspecialchars($do_an['nam_hoc']); ?></td>
                                    <td>
                                        <?php if ($do_an['trang_thai'] === 'Hoàn thành'): ?>
                                            <span class="badge bg-success">Hoàn thành</span>
                                        <?php elseif ($do_an['trang_thai'] === 'Đã hủy'): ?>
                                            <span class="badge bg-danger">Đã hủy</span>
                                        <?php else: ?>
                                            <span class="badge bg-warning text-dark">Đang thực hiện</span>
                                        <?php endif; ?>
                                    </td>
                                    <td><?php echo htmlspecialchars($do_an['created_at']); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="7" class="text-center">Chưa có dữ liệu.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>

</html>