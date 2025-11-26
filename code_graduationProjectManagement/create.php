<?php
session_start();

require 'data.php';

$errors = [];
$input = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $input['ten_de_tai'] = trim($_POST['ten_de_tai'] ?? '');
    $input['ten_sinh_vien'] = trim($_POST['ten_sinh_vien'] ?? '');
    $input['mssv'] = trim($_POST['mssv'] ?? '');
    $input['giang_vien_hd'] = trim($_POST['giang_vien_hd'] ?? '');
    $input['nam_hoc'] = trim($_POST['nam_hoc'] ?? '');
    $input['trang_thai'] = trim($_POST['trang_thai'] ?? 'Đang thực hiện');

    if (empty($input['ten_de_tai'])) {
        $errors['ten_de_tai'] = "Tên đề tài không được để trống.";
    }

    if (empty($input['ten_sinh_vien'])) {
        $errors['ten_sinh_vien'] = "Tên sinh viên không được để trống.";
    }

    if (empty($input['mssv']) || !preg_match('/^[0-9]{8}$/', $input['mssv'])) {
        $errors['mssv'] = "Mã số sinh viên phải bao gồm 8 chữ số.";
    }

    if (empty($input['giang_vien_hd'])) {
        $errors['giang_vien_hd'] = "Giảng viên hướng dẫn không được để trống.";
    }

    if (empty($errors)) {

        $new_do_an_data = [
            'ten_de_tai' => $input['ten_de_tai'],
            'ten_sinh_vien' => $input['ten_sinh_vien'],
            'mssv' => $input['mssv'],
            'giang_vien_hd' => $input['giang_vien_hd'],
            'nam_hoc' => $input['nam_hoc'],
            'trang_thai' => $input['trang_thai'],
        ];

        $_SESSION['new_do_an'] = $new_do_an_data;

        header('Location: index.php?success=created');
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Thêm Đồ Án Mới</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container mt-2 mb-3">
            <span class="navbar-brand fw-bold">QUẢN LÝ ĐỒ ÁN TỐT NGHIỆP</span>
            <div>
                <a href="index.php" class="btn btn-outline-light me-2">Dashboard</a>
                <a href="create.php" class="btn btn-primary">+ Thêm đồ án</a>
            </div>
        </div>
    </nav>

    <div class="container mt-3 mb-4">
        <div class="card shadow">
            <div class="card-body">

                <h3 class="mb-4 text-center">Thêm Đồ Án Mới</h3>

                <form method="POST" action="create.php">

                    <!-- Tên đề tài -->
                    <div class="mb-3">
                        <label class="form-label">Tên đề tài (*)</label>
                        <input type="text"
                            class="form-control <?php echo isset($errors['ten_de_tai']) ? 'is-invalid' : ''; ?>"
                            name="ten_de_tai" value="<?php echo htmlspecialchars($input['ten_de_tai'] ?? ''); ?>">
                        <?php if (isset($errors['ten_de_tai'])): ?>
                            <div class="invalid-feedback"><?php echo $errors['ten_de_tai']; ?></div>
                        <?php endif; ?>
                    </div>

                    <!-- Tên sinh viên -->
                    <div class="mb-3">
                        <label class="form-label">Tên sinh viên (*)</label>
                        <input type="text"
                            class="form-control <?php echo isset($errors['ten_sinh_vien']) ? 'is-invalid' : ''; ?>"
                            name="ten_sinh_vien" value="<?php echo htmlspecialchars($input['ten_sinh_vien'] ?? ''); ?>">
                        <?php if (isset($errors['ten_sinh_vien'])): ?>
                            <div class="invalid-feedback"><?php echo $errors['ten_sinh_vien']; ?></div>
                        <?php endif; ?>
                    </div>

                    <!-- MSSV -->
                    <div class="mb-3">
                        <label class="form-label">Mã số sinh viên (8 chữ số) (*)</label>
                        <input type="text"
                            class="form-control <?php echo isset($errors['mssv']) ? 'is-invalid' : ''; ?>" name="mssv"
                            value="<?php echo htmlspecialchars($input['mssv'] ?? ''); ?>">
                        <?php if (isset($errors['mssv'])): ?>
                            <div class="invalid-feedback"><?php echo $errors['mssv']; ?></div>
                        <?php endif; ?>
                    </div>

                    <!-- Giảng viên hướng dẫn -->
                    <div class="mb-3">
                        <label class="form-label">Giảng viên hướng dẫn (*)</label>
                        <input type="text"
                            class="form-control <?php echo isset($errors['giang_vien_hd']) ? 'is-invalid' : ''; ?>"
                            name="giang_vien_hd" value="<?php echo htmlspecialchars($input['giang_vien_hd'] ?? ''); ?>">
                        <?php if (isset($errors['giang_vien_hd'])): ?>
                            <div class="invalid-feedback"><?php echo $errors['giang_vien_hd']; ?></div>
                        <?php endif; ?>
                    </div>

                    <!-- Năm học -->
                    <div class="mb-3">
                        <label class="form-label">Năm học</label>
                        <select class="form-select" name="nam_hoc">
                            <option value="2024-2025">2024-2025</option>
                            <option value="2023-2024">2023-2024</option>
                        </select>
                    </div>

                    <!-- Trạng thái -->
                    <div class="mb-3">
                        <label class="form-label">Trạng thái</label>
                        <select class="form-select" name="trang_thai">
                            <option value="Đang thực hiện">Đang thực hiện</option>
                            <option value="Hoàn thành">Hoàn thành</option>
                            <option value="Đã hủy">Đã hủy</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-success w-100">Thêm Đồ Án</button>
                </form>
            </div>
        </div>
    </div>
</body>

</html>