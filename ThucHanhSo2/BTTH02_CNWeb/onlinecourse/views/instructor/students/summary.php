<?php
// File: views/instructor/students/summary.php
// Hiển thị tổng quan TẤT CẢ học viên và tiến độ của họ trên TẤT CẢ các khóa học của Giảng viên.
// Dữ liệu cần: $allEnrollments (Tất cả đăng ký), $totalStudents (Tổng số học viên duy nhất)
// Giả định BASE_URL, $_SESSION['fullname'] đã được định nghĩa
$allEnrollments = $allEnrollments ?? [];
$totalStudents = $totalStudents ?? 0;
// Bổ sung: Giả định $_SESSION['fullname'] tồn tại
if (!isset($_SESSION['fullname'])) {
    $_SESSION['fullname'] = 'Giảng viên A'; // Tên mặc định nếu chưa set session
}
?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tổng quan Học viên - Giảng viên</title>
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* CSS Cơ bản - Sử dụng lại style từ các file trước */
        /* Modern Dashboard Styles - Đồng bộ với layout trước */
        :root {
            --primary: #4361ee;
            --primary-light: #eef2ff;
            --secondary: #3a0ca3;
            --success: #10b981;
            --warning: #f59e0b;
            --danger: #ef4444;
            --info: #06b6d4;
            --dark: #1e293b;
            --light: #f8fafc;
            --gray: #64748b;
            --gray-light: #e2e8f0;
            --border: #e2e8f0;
            --shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            --shadow-lg: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
            --radius: 12px;
            --radius-sm: 8px;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background: var(--light);
            color: var(--dark);
            min-height: 100vh;
        }

        /* Modern Layout */
        .modern-layout {
            display: grid;
            grid-template-columns: 280px 1fr;
            min-height: 100vh;
        }

        /* Sidebar */
        .modern-sidebar {
            background: linear-gradient(180deg, #1e293b 0%, #0f172a 100%);
            color: white;
            padding: 0;
            position: sticky;
            top: 0;
            height: 100vh;
            overflow-y: auto;
        }

        .sidebar-header {
            padding: 24px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            text-align: center;
        }

        .sidebar-logo {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 24px;
            justify-content: center;
        }

        .sidebar-logo i {
            font-size: 28px;
            color: #60a5fa;
        }

        .sidebar-logo span {
            font-size: 20px;
            font-weight: 700;
            background: linear-gradient(135deg, #60a5fa 0%, #a855f7 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .sidebar-user {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: var(--radius-sm);
            margin-top: 16px;
        }

        .sidebar-user-avatar {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, #3b82f6, #8b5cf6);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
        }

        .sidebar-user-info h4 {
            margin: 0;
            font-size: 14px;
            font-weight: 600;
        }

        .sidebar-user-info p {
            margin: 0;
            font-size: 12px;
            color: #94a3b8;
        }

        .sidebar-menu {
            padding: 20px 0;
        }

        .sidebar-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 14px 24px;
            color: #cbd5e1;
            text-decoration: none;
            transition: all 0.3s ease;
            position: relative;
            border-left: 3px solid transparent;
        }

        .sidebar-item:hover {
            background: rgba(255, 255, 255, 0.05);
            color: white;
            border-left-color: #3b82f6;
        }

        .sidebar-item.active {
            background: rgba(59, 130, 246, 0.1);
            color: white;
            border-left-color: #3b82f6;
        }

        .sidebar-item i {
            width: 20px;
            text-align: center;
        }

        .badge-count {
            background: var(--danger);
            color: white;
            font-size: 11px;
            padding: 2px 8px;
            border-radius: 10px;
            margin-left: auto;
        }

        /* Main Content */
        .modern-content {
            padding: 0;
            overflow-x: hidden;
        }

        /* === BỔ SUNG/CẬP NHẬT: Top Navigation Bar === */
        .top-nav {
            background: white;
            padding: 20px 30px;
            box-shadow: var(--shadow-lg);
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid var(--border);
            position: sticky;
            /* Giữ top-nav cố định */
            top: 0;
            z-index: 1000;
        }

        .top-nav-left h1 {
            font-size: 24px;
            color: var(--dark);
            margin: 0;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .top-nav-right {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        /* Nút quay lại Trang chủ (Mới thêm) */
        .top-nav-right .btn-home {
            color: var(--gray);
            font-size: 1.2rem;
            transition: color 0.3s;
        }

        .top-nav-right .btn-home:hover {
            color: var(--primary);
        }


        .top-nav-right .btn-logout {
            background: var(--danger);
            color: white;
            padding: 8px 15px;
            border-radius: var(--radius-sm);
            text-decoration: none;
            font-weight: 500;
            transition: background 0.3s ease;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .top-nav-right .btn-logout:hover {
            background: #c53030;
        }

        .content-area {
            padding: 30px;
            /* CẬP NHẬT: Đồng bộ với Dashboard */
        }

        /* === KẾT THÚC CẬP NHẬT: Top Navigation Bar === */

        .stats-summary {
            background: #eef2ff;
            border-left: 5px solid #4f46e5;
            padding: 15px;
            border-radius: 6px;
            margin-bottom: 25px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .stats-summary p {
            margin: 0;
            font-size: 16px;
            color: #1e293b;
            font-weight: 500;
        }

        /* Table Styles */
        .summary-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .summary-table th,
        .summary-table td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #e2e8f0;
            font-size: 14px;
        }

        .summary-table th {
            background-color: #f3f4f6;
            color: #1e293b;
            font-weight: 600;
            text-transform: uppercase;
        }

        .summary-table tbody tr:hover {
            background-color: #f8fafc;
        }

        /* Progress Bar (Sử dụng lại từ list.php) */
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
            transition: width 0.5s ease;
        }

        /* Badges (Sử dụng lại từ list.php) */
        .badge {
            padding: 4px 10px;
            border-radius: 15px;
            font-size: 0.75em;
            font-weight: 600;
            text-transform: capitalize;
        }

        .badge-success {
            background: #dcfce7;
            color: #047857;
        }

        .badge-warning {
            background: #fef3c7;
            color: #d97706;
        }

        .badge-danger {
            background: #fee2e2;
            color: #991b1b;
        }

        .action-link {
            color: #4f46e5;
            text-decoration: none;
            transition: color 0.3s;
        }

        .action-link:hover {
            color: #3a0ca3;
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

        @media (max-width: 768px) {
            .modern-layout {
                grid-template-columns: 1fr;
            }

            .modern-sidebar {
                display: none;
                /* Ẩn sidebar trên mobile, cần toggle button nếu muốn hiển thị */
            }

            .top-nav {
                padding: 16px;
                flex-direction: column;
                gap: 12px;
                align-items: stretch;
            }

            .top-nav-right {
                flex-direction: row;
                justify-content: flex-end;
            }

            .content-area {
                padding: 16px;
            }
        }
    </style>
</head>

<body>
    <div class="modern-layout">
        <aside class="modern-sidebar">
            <div class="sidebar-header">
                <div class="sidebar-logo">
                    <i class="fas fa-graduation-cap"></i>
                    <span>EduMaster</span>
                </div>
                <div class="sidebar-user">
                    <div class="sidebar-user-avatar">
                        <i class="fas fa-user"></i>
                    </div>
                    <div class="sidebar-user-info">
                        <h4><?php echo htmlspecialchars($_SESSION['fullname'] ?? 'Giảng viên'); ?></h4>
                        <p>Giảng viên</p>
                    </div>
                </div>
            </div>

            <nav class="sidebar-menu">
                <a href="<?php echo BASE_URL; ?>/instructor/dashboard" class="sidebar-item">
                    <i class="fas fa-home"></i>
                    <span>Dashboard</span>
                </a>
                <a href="<?php echo BASE_URL; ?>/course/manage" class="sidebar-item">
                    <i class="fas fa-book"></i>
                    <span>Khóa học của tôi</span>
                </a>
                <a href="<?php echo BASE_URL; ?>/course/create" class="sidebar-item">
                    <i class="fas fa-plus-circle"></i>
                    <span>Tạo khóa học</span>
                </a>
                <a href="<?php echo BASE_URL; ?>/instructor/enrollments" class="sidebar-item active">
                    <i class="fas fa-users"></i>
                    <span>Học viên</span>
                </a>
                <a href="<?php echo BASE_URL; ?>/instructor/progress" class="sidebar-item">
                    <i class="fas fa-chart-line"></i>
                    <span>Theo dõi tiến độ</span>
                </a>
                <div class="sidebar-divider"></div>
                <a href="<?php echo BASE_URL; ?>/" class="sidebar-item" target="_blank">
                    <i class="fas fa-external-link-alt"></i>
                    <span>Xem trang chủ</span>
                </a>
            </nav>
        </aside>

        <div class="modern-content">
            <nav class="top-nav">
                <div class="top-nav-left">
                    <h1><i class="fas fa-users"></i> Tổng quan Học viên</h1>
                </div>

                <div class="top-nav-right">

                    <a href="<?php echo BASE_URL; ?>/auth/logout" class="btn-logout">
                        <i class="fas fa-sign-out-alt"></i>
                        Đăng xuất
                    </a>
                </div>
            </nav>
            <div class="content-area">

                <?php
                // Tính toán tổng số đăng ký và số học viên duy nhất (Nếu chưa làm trong Controller)
                $totalEnrollments = isset($allEnrollments) ? count($allEnrollments) : 0;
                // Nếu $totalStudents chưa được truyền từ Controller, tính toán lại
                if ($totalStudents == 0 && $totalEnrollments > 0) {
                    $uniqueStudentIds = array_unique(array_column($allEnrollments, 'student_id'));
                    $totalStudents = count($uniqueStudentIds);
                }

                ?>
                <div class="stats-summary">
                    <p>Tổng số đăng ký: **<?php echo $totalEnrollments; ?>**</p>
                    <p>Tổng số học viên duy nhất: **<?php echo $totalStudents; ?>**</p>
                </div>


                <?php if (!empty($allEnrollments)): ?>
                    <div style="overflow-x: auto; background: white; padding: 20px; border-radius: var(--radius);">
                        <table class="summary-table">
                            <thead>
                                <tr>
                                    <th>ID HV</th>
                                    <th>Họ và Tên</th>
                                    <th>Khóa học</th>
                                    <th>Ngày đăng ký</th>
                                    <th style="width: 150px;">Tiến độ</th>
                                    <th>Trạng thái</th>
                                    <th>Chi tiết</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($allEnrollments as $item): ?>
                                    <tr>
                                        <td><?php echo $item['student_id'] ?? 'N/A'; ?></td>
                                        <td><?php echo htmlspecialchars($item['student_name'] ?? 'N/A'); ?></td>
                                        <td>
                                            <a href="<?php echo BASE_URL; ?>/course/detail/<?php echo $item['course_id'] ?? '#'; ?>"
                                                class="action-link" target="_blank">
                                                <?php echo htmlspecialchars($item['course_title'] ?? 'N/A'); ?>
                                            </a>
                                        </td>
                                        <td><?php echo date('d/m/Y', strtotime($item['enrolled_date'] ?? 'now')); ?></td>
                                        <td>
                                            <?php $progress = $item['progress'] ?? 0; ?>
                                            <div class="progress-bar-container">
                                                <div class="progress-fill" style="width: <?php echo $progress; ?>%;"></div>
                                            </div>
                                            <small>**<?php echo $progress; ?>%**</small>
                                        </td>
                                        <td>
                                            <?php
                                            $status = $item['enrollment_status'] ?? 'active';
                                            $status_display = match ($status) {
                                                'completed' => 'Hoàn thành',
                                                'dropped' => 'Hủy khóa học',
                                                default => 'Đang học'
                                            };
                                            $badge_class = match ($status) {
                                                'completed' => 'badge-success',
                                                'dropped' => 'badge-danger',
                                                default => 'badge-warning'
                                            };
                                            ?>
                                            <span class="badge <?php echo $badge_class; ?>">
                                                <?php echo htmlspecialchars($status_display); ?>
                                            </span>
                                        </td>
                                        <td>
                                            <a href="<?php echo BASE_URL; ?>/enrollment/progress/<?php echo $item['course_id'] ?? '#'; ?>/<?php echo $item['student_id'] ?? '#'; ?>"
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
                        <i class="fas fa-user-slash"></i>
                        <h3>Chưa có học viên nào</h3>
                        <p>Hiện tại chưa có học viên nào đăng ký vào bất kỳ khóa học nào do bạn tạo.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>

</html>