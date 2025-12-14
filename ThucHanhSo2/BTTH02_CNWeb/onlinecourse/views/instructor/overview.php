<?php
// File: views/instructor/progress/overview.php
// Hiển thị tổng quan tiến độ của TẤT CẢ các khóa học do Giảng viên sở hữu.
// Dữ liệu cần: $totalStudents, $enrollmentCount, $courseSummary, $pendingCourses, $avgCompletionRate
// Giả định BASE_URL đã được định nghĩa
$totalStudents = $totalStudents ?? 0;
$enrollmentCount = $enrollmentCount ?? 0;
$courseSummary = $courseSummary ?? [];
$avgCompletionRate = $avgCompletionRate ?? 0;
$pendingCourses = $pendingCourses ?? 0;

// Thiết lập biến active menu cho Sidebar Giảng viên
$activeMenu = 'progress';
// Giả định $_SESSION['fullname'] đã có
$fullname = htmlspecialchars($_SESSION['fullname'] ?? 'Giảng viên');
?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Theo dõi Tiến độ Khóa học - Giảng viên</title>
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    <style>
        /* ================================================= */
        /* MODERN DASHBOARD STYLES (Đã đồng bộ) */
        /* ================================================= */
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
            /* Giữ font Inter cho dashboard, khác với Segoe UI trong snippet */
            font-family: 'Inter', sans-serif;
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
            margin-bottom: 15px;
            /* Giảm margin bottom */
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

        /* Sidebar User Info */
        .sidebar-user {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: var(--radius-sm);
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
            flex-grow: 1;
            /* Thêm để đảm bảo chiếm hết không gian còn lại */
            padding: 0;
            overflow-x: hidden;
            display: flex;
            flex-direction: column;
        }

        /* Top Navigation */
        .top-nav {
            background: white;
            padding: 16px 32px;
            border-bottom: 1px solid var(--border);
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 100;
            box-shadow: var(--shadow);
        }

        .top-nav-left {
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .page-title {
            font-size: 24px;
            font-weight: 700;
            color: var(--dark);
            margin: 0;
        }

        .page-subtitle {
            font-size: 14px;
            color: var(--gray);
            margin: 0;
        }



        .btn-view-home {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 20px;
            background: white;
            color: var(--primary);
            border: 1px solid var(--primary);
            border-radius: var(--radius-sm);
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s;
        }

        .btn-view-home:hover {
            background: var(--primary);
            color: white;
            transform: translateY(-2px);
        }

        /* Main Content Area - Đã tinh chỉnh */
        .content-area {
            padding: 32px;
            max-width: 1400px;
            width: 100%;
            /* Đảm bảo chiếm đủ chiều rộng */
            margin: 0 auto;
            flex-grow: 1;
            /* Quan trọng: Đảm bảo phần nội dung chiếm hết không gian còn lại */
        }

        .me-2 {
            margin-right: 0.5rem !important;
        }


        /* ================================================= */
        /* CONTENT STYLES (Sử dụng lại class của bạn, đồng bộ màu sắc) */
        /* ================================================= */

        /* Header Content */
        .content-area h1 {
            font-size: 24px;
            font-weight: 700;
            color: var(--dark);
            margin-top: 0;
            margin-bottom: 5px;
        }

        .content-area p {
            color: var(--gray);
            margin-bottom: 20px;
        }

        .content-area h3 {
            font-size: 20px;
            font-weight: 600;
            margin-bottom: 15px;
            color: var(--dark);
        }

        /* Stats Cards */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: white;
            /* Đổi nền trắng */
            padding: 25px;
            border-radius: var(--radius-sm);
            border-left: 5px solid var(--primary);
            /* Dùng biến */
            box-shadow: var(--shadow);
            /* Dùng biến */
            transition: all 0.3s;
        }

        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-lg);
        }

        .stat-card h4 {
            font-size: 14px;
            color: var(--gray);
            margin-bottom: 5px;
            text-transform: uppercase;
        }

        .stat-card p {
            font-size: 28px;
            font-weight: 700;
            color: var(--dark);
        }

        /* Table */
        .progress-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background: white;
            border-radius: var(--radius);
            overflow: hidden;
            box-shadow: var(--shadow);
        }

        .progress-table th,
        .progress-table td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid var(--border);
            font-size: 14px;
            vertical-align: middle;
        }

        .progress-table th {
            background-color: var(--primary-light);
            /* Dùng biến */
            color: var(--primary);
            /* Dùng biến */
            font-weight: 600;
        }

        .progress-table tbody tr:hover {
            background-color: var(--light);
        }

        /* Progress Bar */
        .progress-bar-container {
            height: 10px;
            background: var(--gray-light);
            border-radius: 5px;
            overflow: hidden;
        }

        .progress-fill-avg {
            height: 100%;
            background: var(--success);
            /* Dùng biến */
            transition: width 0.5s ease;
        }

        /* Badges */
        .badge-success {
            display: inline-block;
            background: #dcfce7;
            color: #047857;
            padding: 4px 8px;
            border-radius: 12px;
            font-weight: 600;
            font-size: 12px;
        }

        .action-btn-small {
            color: var(--primary);
            text-decoration: none;
            padding: 5px;
            border-radius: 4px;
            transition: background 0.3s;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }

        .action-btn-small:hover {
            background: var(--primary-light);
        }

        .no-data {
            text-align: center;
            color: var(--gray);
            padding: 60px;
            border: 1px dashed var(--border);
            border-radius: var(--radius);
            margin-top: 30px;
            background: white;
            box-shadow: var(--shadow);
        }

        .no-data i {
            font-size: 3rem;
            margin-bottom: 15px;
            color: var(--gray);
        }

        /* Responsive */
        @media (max-width: 768px) {
            .modern-layout {
                grid-template-columns: 1fr;
            }

            .modern-sidebar {
                position: fixed;
                left: 0;
                top: 0;
                margin-left: -280px;
                z-index: 1050;
                transition: margin-left 0.3s ease;
                box-shadow: var(--shadow-lg);
            }

            .modern-sidebar.active {
                margin-left: 0;
            }

            .top-nav {
                padding: 16px 20px;
            }

            .top-nav-right {
                display: flex;
                gap: 16px;
                align-items: center;
            }

            .content-area {
                padding: 20px;
            }

            .page-title {
                font-size: 20px;
            }

            .page-subtitle,
            .btn-view-home {
                display: none;
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
                        <h4><?php echo $fullname; ?></h4>
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
                <a href="<?php echo BASE_URL; ?>/instructor/enrollments" class="sidebar-item">
                    <i class="fas fa-users"></i>
                    <span>Học viên</span>
                </a>
                <a href="<?php echo BASE_URL; ?>/instructor/progress" class="sidebar-item active">
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

        <main class="modern-content">
            <nav class="top-nav">
                <div class="top-nav-left">

                    <h1 class="page-title">Theo dõi Tiến độ Khóa học</h1>
                    <p class="page-subtitle">Tổng quan về hiệu suất và mức độ tương tác.</p>
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
                // Khởi tạo các giá trị (Đảm bảo các biến được định nghĩa)
                // Các biến đã được khởi tạo ở đầu file
                ?>

                <div class="stats-grid">
                    <div class="stat-card">
                        <h4>Tổng số Học viên</h4>
                        <p><?php echo number_format($totalStudents); ?></p>
                    </div>
                    <div class="stat-card">
                        <h4>Tổng lượt Đăng ký</h4>
                        <p><?php echo number_format($enrollmentCount); ?></p>
                    </div>
                    <div class="stat-card">
                        <h4>Tỷ lệ Hoàn thành TB</h4>
                        <p><?php echo $avgCompletionRate; ?>%</p>
                        <div class="progress-bar-container">
                            <div class="progress-fill-avg" style="width: <?php echo $avgCompletionRate; ?>%;"></div>
                        </div>
                    </div>
                    <div class="stat-card" style="border-left-color: var(--warning);">
                        <h4>Khóa học Chờ duyệt</h4>
                        <p><?php echo $pendingCourses; ?></p>
                    </div>
                </div>

                <h3><i class="fas fa-list-alt me-2"></i> Hiệu suất theo từng Khóa học</h3>

                <?php if (!empty($courseSummary)): ?>
                    <div style="overflow-x: auto;">
                        <table class="progress-table">
                            <thead>
                                <tr>
                                    <th>Khóa học</th>
                                    <th>Tổng HV</th>
                                    <th>Tỷ lệ Hoàn thành</th>
                                    <th style="width: 250px;">Phân tích</th>
                                    <th>Hành động</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($courseSummary as $course): ?>
                                    <?php
                                    // 1. KHẮC PHỤC LỖI CHIA CHO 0: Kiểm tra total_students
                                    $totalStudentsCourse = $course['total_students'] ?? 0;
                                    $completedCount = $course['completed_count'] ?? 0;

                                    $completionRate = ($totalStudentsCourse > 0)
                                        ? round(($completedCount / $totalStudentsCourse) * 100)
                                        : 0;
                                    ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($course['title']); ?></td>
                                        <td><?php echo number_format($totalStudentsCourse); ?></td>
                                        <td>
                                            <span class="badge-success"><?php echo $completionRate; ?>%</span>
                                        </td>
                                        <td>
                                            <div class="progress-bar-container">
                                                <div class="progress-fill-avg" style="width: <?php echo $completionRate; ?>%;">
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <a href="<?php echo BASE_URL; ?>/enrollment/listStudents/<?php echo $course['id']; ?>"
                                                class="action-btn-small" title="Xem danh sách học viên khóa học này">
                                                <i class="fas fa-users"></i> Học viên
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <div class="no-data">
                        <i class="fas fa-book-open"></i>
                        <h3>Hãy bắt đầu giảng dạy!</h3>
                        <p>Bạn chưa có khóa học nào được phê duyệt hoặc chưa có học viên nào đăng ký.</p>
                    </div>
                <?php endif; ?>
            </div>
        </main>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.querySelector('.modern-sidebar');
            const toggleButton = document.querySelector('.fa-bars');
            const mainContent = document.querySelector('.modern-content');

            if (toggleButton) {
                toggleButton.addEventListener('click', function() {
                    sidebar.classList.toggle('active');
                });
            }

            // Đóng sidebar khi click ra ngoài trên mobile
            mainContent.addEventListener('click', function(e) {
                // Kiểm tra nếu màn hình là mobile (<= 992px) và sidebar đang mở
                if (window.innerWidth <= 992 && sidebar.classList.contains('active')) {
                    // Kiểm tra xem cú click có phải là trên sidebar hoặc nút toggle không
                    if (!sidebar.contains(e.target) && !toggleButton.contains(e.target)) {
                        sidebar.classList.remove('active');
                    }
                }
            });
        });
    </script>
</body>

</html>