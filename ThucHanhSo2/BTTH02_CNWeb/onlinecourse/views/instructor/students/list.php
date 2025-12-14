<?php
// File: views/instructor/students/list.php
// Dữ liệu cần: $course (Thông tin khóa học), $students (Danh sách học viên)
// Giả định BASE_URL đã được định nghĩa
?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh sách Học viên - <?php echo htmlspecialchars($course['title'] ?? 'Khóa học'); ?></title>
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* CSS DÀNH RIÊNG CHO TRANG NÀY - Đã tối ưu cho Dashboard Giảng viên */
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f7f9;
        }

        .container {
            max-width: 1200px;
            margin: 50px auto;
            padding: 30px;
            background: white;
            border-radius: 12px;
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
        }

        h1 {
            color: #4f46e5;
            border-bottom: 2px solid #e0e7ff;
            padding-bottom: 15px;
            margin-bottom: 25px;
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 28px;
        }

        .course-info {
            background: #eef2ff;
            border-left: 5px solid #4f46e5;
            padding: 15px;
            border-radius: 6px;
            margin-bottom: 25px;
        }

        .course-info h2 {
            font-size: 20px;
            color: #1e293b;
            margin-top: 0;
        }

        .course-info p {
            margin: 5px 0;
            font-size: 14px;
            color: #64748b;
        }

        /* Table Styles */
        .student-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .student-table th,
        .student-table td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #e2e8f0;
            font-size: 14px;
        }

        .student-table th {
            background-color: #f3f4f6;
            color: #1e293b;
            font-weight: 600;
            text-transform: uppercase;
        }

        .student-table tbody tr:hover {
            background-color: #f8fafc;
        }

        /* Progress Bar */
        .progress-bar-container {
            height: 10px;
            background: #e2e8f0;
            border-radius: 5px;
            overflow: hidden;
            margin-top: 5px;
        }

        .progress-fill {
            height: 100%;
            background: #10b981;
            /* Green color */
            transition: width 0.5s ease;
        }

        /* Badges */
        .badge {
            padding: 4px 10px;
            border-radius: 15px;
            font-size: 0.75em;
            font-weight: 600;
            text-transform: capitalize;
            /* Chuyển thành viết hoa chữ cái đầu */
        }

        /* completed */
        .badge-success {
            background: #dcfce7;
            color: #047857;
        }

        /* active */
        .badge-warning {
            background: #fef3c7;
            color: #d97706;
        }

        /* dropped */
        .badge-danger {
            background: #fee2e2;
            color: #991b1b;
        }

        /* No Data */
        .no-data {
            text-align: center;
            color: #6b7280;
            padding: 60px;
            border: 1px dashed #e2e8f0;
            border-radius: 8px;
            margin-top: 30px;
        }

        .no-data i {
            font-size: 3em;
            margin-bottom: 15px;
            color: #cbd5e1;
        }

        /* Action Link */
        .action-link {
            color: #4f46e5;
            text-decoration: none;
            transition: color 0.3s;
        }

        .action-link:hover {
            color: #3a0ca3;
        }

        .action-btn {
            display: inline-block;
            padding: 8px;
            border-radius: 4px;
            transition: background 0.3s;
        }

        .action-btn:hover {
            background-color: #eef2ff;
        }

        @media (max-width: 768px) {
            .container {
                margin: 20px;
                padding: 15px;
            }

            .student-table th,
            .student-table td {
                padding: 10px;
            }

            .student-table {
                font-size: 12px;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <a href="<?php echo BASE_URL; ?>/course/manage" class="action-link"
            style="margin-bottom: 20px; display: inline-block;">
            <i class="fas fa-arrow-left"></i> Quay lại Quản lý Khóa học
        </a>

        <h1><i class="fas fa-users"></i> Danh sách Học viên</h1>

        <div class="course-info">
            <h2>Khóa học: <?php echo htmlspecialchars($course['title'] ?? 'N/A'); ?></h2>
            <p>ID Khóa học: **<?php echo $course['id'] ?? 'N/A'; ?>** | Trạng thái:
                **<?php echo htmlspecialchars($course['status'] ?? 'N/A'); ?>**</p>
            <p>Mô tả:
                <?php echo htmlspecialchars(mb_substr($course['description'] ?? 'Không có mô tả.', 0, 150, 'UTF-8')); ?>...
            </p>
        </div>

        <?php if (!empty($students)): ?>
            <p style="font-size: 16px; margin-bottom: 15px;">Tổng số học viên đã đăng ký:
                **<?php echo count($students); ?>**</p>
            <div style="overflow-x: auto;">
                <table class="student-table">
                    <thead>
                        <tr>
                            <th>ID HV</th>
                            <th>Họ và Tên</th>
                            <th>Email</th>
                            <th>Ngày đăng ký</th>
                            <th style="width: 150px;">Tiến độ</th>
                            <th>Trạng thái</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($students as $student): ?>
                            <tr>
                                <td><?php echo $student['student_id']; ?></td>
                                <td><?php echo htmlspecialchars($student['fullname'] ?? 'N/A'); ?></td>
                                <td><?php echo htmlspecialchars($student['email'] ?? 'N/A'); ?></td>
                                <td><?php echo date('d/m/Y', strtotime($student['enrolled_date'] ?? 'N/A')); ?></td>
                                <td>
                                    <?php $progress = $student['progress'] ?? 0; ?>
                                    <div class="progress-bar-container">
                                        <div class="progress-fill" style="width: <?php echo $progress; ?>%;"></div>
                                    </div>
                                    <small>**<?php echo $progress; ?>%**</small>
                                </td>
                                <td>
                                    <?php
                                    // Gán giá trị mặc định nếu không tồn tại
                                    $status = $student['status'] ?? 'active';

                                    // Xác định class CSS cho badge
                                    $badge_class = match ($status) {
                                        'completed' => 'badge-success',
                                        'dropped' => 'badge-danger',
                                        default => 'badge-warning' // Mặc định là 'active' hoặc trạng thái khác
                                    };

                                    // Chuyển đổi trạng thái sang tiếng Việt
                                    $status_display = match ($status) {
                                        'completed' => 'Hoàn thành',
                                        'dropped' => 'Hủy khóa học',
                                        default => 'Đang học'
                                    };
                                    ?>
                                    <span class="badge <?php echo $badge_class; ?>">
                                        <?php echo htmlspecialchars($status_display); ?>
                                    </span>
                                </td>
                                <td>
                                    <a href="<?php echo BASE_URL; ?>/enrollment/progress/<?php echo $course['id']; ?>/<?php echo $student['student_id']; ?>"
                                        title="Xem chi tiết tiến độ" class="action-link action-btn">
                                        <i class="fas fa-chart-line"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="no-data">
                <i class="fas fa-box-open"></i>
                <h3>Chưa có học viên nào</h3>
                <p>Khóa học này hiện chưa có học viên nào đăng ký. Hãy kiểm tra nội dung và quảng bá khóa học!</p>
                <a href="<?php echo BASE_URL; ?>/course/edit/<?php echo $course['id'] ?? ''; ?>" class="action-link"
                    style="font-weight: 600;">
                    <i class="fas fa-edit"></i> Chỉnh sửa khóa học
                </a>
            </div>
        <?php endif; ?>
    </div>
</body>

</html>