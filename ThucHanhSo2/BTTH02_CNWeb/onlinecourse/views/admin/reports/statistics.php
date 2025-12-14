<?php
// File: views/admin/reports/statistics.php
// Dữ liệu cần: $userStats, $courseStats, $enrollmentTrends
// Biến $courseStats có thêm khóa 'avg_enrollments' được tính toán trong Controller/Model
$userStats = $userStats ?? [];
$courseStats = $courseStats ?? ['total_courses' => 0, 'approved_courses' => 0, 'pending_courses' => 0, 'avg_enrollments' => 0];
$enrollmentTrends = $enrollmentTrends ?? [];

// Helper để chuyển đổi User Stats thành mảng dễ truy cập
$userCount = [];
foreach ($userStats as $stats) {
    $userCount[$stats['role']] = $stats['count'];
}
// Thiết lập biến active menu cho Sidebar
$activeMenu = 'statistics';
?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thống kê Hệ thống - Admin</title>
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/style.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/admin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    <style>
        /* ================================================= */
        /* CSS CHUNG VÀ BIẾN MÀU SẮC (Đồng bộ Dashboard) */
        /* ================================================= */
        :root {
            --primary-color: #4f46e5;
            --primary-light: #eef2ff;
            --sidebar-bg: #1e293b;
            --text-color: #334155;
            --gray-light: #f1f5f9;
            --gray-border: #e2e8f0;
            --shadow-sm: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
            --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -2px rgba(0, 0, 0, 0.1);
            --radius-md: 8px;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--gray-light);
            color: var(--text-color);
            line-height: 1.5;
            margin: 0;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        /* --- NAVBAR --- */
        .admin-navbar {
            background: white;
            box-shadow: var(--shadow-sm);
            height: 60px;
            display: flex;
            align-items: center;
            padding: 0 1.5rem;
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .navbar-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
            width: 100%;
        }

        .navbar-brand {
            font-size: 1.25rem;
            font-weight: 800;
            color: var(--primary-color);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .brand-icon {
            width: 30px;
            height: 30px;
            background: var(--primary-color);
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1rem;
        }

        .navbar-actions {
            display: flex;
            align-items: center;
            gap: 1.5rem;
        }

        .user-info strong {
            color: var(--primary-color);
            font-weight: 600;
        }

        .btn-danger-custom {
            background: #ef4444;
            color: white;
            padding: 5px 10px;
            text-decoration: none;
            border-radius: 4px;
            transition: background 0.2s;
            display: flex;
            align-items: center;
            font-weight: 500;
            border: none;
        }

        .btn-danger-custom:hover {
            background: #dc2626;
        }

        /* --- LAYOUT & SIDEBAR --- */
        .admin-layout {
            display: flex;
            flex-grow: 1;
        }

        .admin-sidebar {
            width: 250px;
            background: var(--sidebar-bg);
            color: #cbd5e1;
            padding: 1rem 0;
            height: calc(100vh - 60px);
            position: sticky;
            top: 60px;
            flex-shrink: 0;
            overflow-y: auto;
            transition: margin-left 0.3s ease;
        }

        .sidebar-menu {
            margin-top: 1rem;
        }

        .sidebar-item {
            display: flex;
            align-items: center;
            padding: 12px 1.5rem;
            text-decoration: none;
            color: #cbd5e1;
            transition: all 0.2s ease;
            font-weight: 500;
            gap: 10px;
            margin: 4px 8px;
            border-radius: var(--radius-md);
        }

        .sidebar-item:hover {
            background: #334155;
            color: #fff;
        }

        .sidebar-item.active {
            background: var(--primary-color);
            color: #fff;
            font-weight: 600;
            box-shadow: var(--shadow-sm);
        }

        .admin-content {
            flex-grow: 1;
            padding: 2rem;
            background-color: var(--gray-light);
            max-width: 1200px;
            /* Giữ nguyên max-width từ file gốc */
            margin: 0 auto;
        }

        /* Mobile Toggle */
        .sidebar-toggle {
            display: none;
            cursor: pointer;
            font-size: 1.5rem;
            color: var(--primary-color);
            margin-right: 15px;
        }

        /* Responsive */
        @media (max-width: 992px) {
            .admin-sidebar {
                position: fixed;
                left: 0;
                top: 0;
                height: 100vh;
                margin-left: -250px;
                z-index: 1050;
                padding-top: 60px;
                box-shadow: var(--shadow-md);
            }

            .admin-sidebar.active {
                margin-left: 0;
            }

            .sidebar-toggle {
                display: block;
            }

            .admin-layout {
                margin-top: 0;
            }
        }

        /* ================================================= */
        /* CONTENT STYLES (Giữ nguyên từ file gốc) */
        /* ================================================= */

        .content-header {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            margin-bottom: 2rem;
            border-bottom: 2px solid var(--gray-border);
            padding-bottom: 1rem;
        }

        .content-header h1 {
            color: var(--text-color);
            font-size: 1.75rem;
            font-weight: 700;
            margin: 0 0 0.5rem 0;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .content-header p {
            color: #64748b;
            margin: 0;
        }

        .card {
            background: #fff;
            border-radius: var(--radius-md);
            box-shadow: var(--shadow-md);
            margin-bottom: 2rem;
        }

        .card-header {
            padding: 1rem 1.5rem;
            border-bottom: 1px solid #e5e7eb;
            font-weight: 600;
            color: var(--text-color);
        }

        .card-body {
            padding: 1.5rem;
        }

        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 0;
        }

        .data-table th,
        .data-table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #e2e8f0;
            font-size: 14px;
            vertical-align: middle;
        }

        .data-table th {
            background-color: var(--primary-light);
            color: var(--primary-color);
            font-weight: 600;
        }

        /* Metric Cards */
        .stat-grid-4 {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1.5rem;
            margin-bottom: 1.5rem;
        }

        .stat-card-small {
            background: #f8fafc;
            border-radius: 6px;
            padding: 1rem;
            border: 1px solid #e2e8f0;
        }

        .metric-title {
            font-size: 14px;
            color: #64748b;
            font-weight: 600;
            margin-bottom: 0.25rem;
        }

        .metric-value {
            font-size: 24px;
            color: #1e293b;
            font-weight: 700;
        }

        /* Alerts */
        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 4px;
        }

        .alert-success {
            background-color: #d4edda;
            color: #155724;
        }

        .alert-error {
            background-color: #f8d7da;
            color: #721c24;
        }

        .alert-info {
            background-color: #f0f8ff;
            border: 1px solid #b3e5fc;
            color: #004085;
        }
    </style>
</head>

<body>
    <nav class="admin-navbar">
        <div class="navbar-content">
            <div style="display: flex; align-items: center;">
                <i class="fas fa-bars sidebar-toggle me-3"
                    onclick="document.querySelector('.admin-sidebar').classList.toggle('active');"></i>
                <div class="navbar-brand">
                    <div class="brand-icon">
                        <i class="fas fa-graduation-cap"></i>
                    </div>
                    <span>Online Course - Admin</span>
                </div>
            </div>

            <div class="navbar-actions">
                <span class="user-info d-none d-sm-block">Xin chào,
                    <strong><?php echo htmlspecialchars($_SESSION['fullname'] ?? 'Admin'); ?></strong>
                </span>
                <a href="<?php echo BASE_URL; ?>/auth/logout" class="btn-danger-custom">
                    <i class="fas fa-sign-out-alt me-1"></i> Đăng xuất
                </a>
            </div>
        </div>
    </nav>

    <div class="admin-layout">
        <aside class="admin-sidebar">
            <div class="sidebar-menu">
                <a href="<?php echo BASE_URL; ?>/admin/dashboard"
                    class="sidebar-item <?php echo ($activeMenu == 'dashboard') ? 'active' : ''; ?>">
                    <i class="fas fa-tachometer-alt"></i> Dashboard
                </a>
                <a href="<?php echo BASE_URL; ?>/admin/users"
                    class="sidebar-item <?php echo ($activeMenu == 'users') ? 'active' : ''; ?>">
                    <i class="fas fa-users"></i> Quản lý người dùng
                </a>
                <a href="<?php echo BASE_URL; ?>/admin/categories"
                    class="sidebar-item <?php echo ($activeMenu == 'categories') ? 'active' : ''; ?>">
                    <i class="fas fa-list"></i> Danh mục
                </a>
                <a href="<?php echo BASE_URL; ?>/admin/systemStatistics"
                    class="sidebar-item <?php echo ($activeMenu == 'statistics') ? 'active' : ''; ?>">
                    <i class="fas fa-chart-bar"></i> Thống kê Hệ thống
                </a>
                <a href="<?php echo BASE_URL; ?>/admin/courseApproval"
                    class="sidebar-item <?php echo ($activeMenu == 'approval') ? 'active' : ''; ?>">
                    <i class="fas fa-check-circle"></i> Duyệt khóa học
                </a>
            </div>
        </aside>

        <main class="admin-content">
            <div class="content-header">
                <h1><i class="fas fa-chart-bar"></i> Thống kê Sử dụng Hệ thống</h1>
                <p>Báo cáo chi tiết về người dùng, khóa học và xu hướng đăng ký.</p>
            </div>

            <?php
            // Hiển thị thông báo (nếu có)
            if (isset($_SESSION['message'])): ?>
                <div class="alert alert-<?php echo $_SESSION['message_type']; ?>">
                    <?php echo htmlspecialchars($_SESSION['message']); ?>
                </div>
            <?php
                unset($_SESSION['message']);
                unset($_SESSION['message_type']);
            endif;
            ?>

            <div class="card">
                <div class="card-header">
                    <i class="fas fa-book-open"></i> Báo cáo Khóa học
                </div>
                <div class="card-body">
                    <div class="stat-grid-4">
                        <div class="stat-card-small">
                            <div class="metric-title">Tổng Khóa học</div>
                            <div class="metric-value">
                                <?php echo htmlspecialchars($courseStats['total_courses'] ?? 0); ?>
                            </div>
                        </div>
                        <div class="stat-card-small" style="background: #e6ffed;">
                            <div class="metric-title">Đã duyệt</div>
                            <div class="metric-value" style="color: #10b981;">
                                <?php echo htmlspecialchars($courseStats['approved_courses'] ?? 0); ?>
                            </div>
                        </div>
                        <div class="stat-card-small" style="background: #fffbef;">
                            <div class="metric-title">Chờ duyệt / Draft</div>
                            <div class="metric-value" style="color: #f59e0b;">
                                <?php echo htmlspecialchars($courseStats['pending_courses'] ?? 0); ?>
                            </div>
                        </div>
                        <div class="stat-card-small">
                            <div class="metric-title">TB Đăng ký/Khóa</div>
                            <div class="metric-value">
                                <?php echo number_format($courseStats['avg_enrollments'] ?? 0, 1); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <i class="fas fa-users"></i> Phân loại Người dùng
                </div>
                <div class="card-body">
                    <div class="stat-grid-4">
                        <div class="stat-card-small" style="background: #e0e7ff;">
                            <div class="metric-title">Học viên (0)</div>
                            <div class="metric-value" style="color: #4f46e5;">
                                <?php echo htmlspecialchars($userCount[0] ?? 0); ?>
                            </div>
                        </div>
                        <div class="stat-card-small" style="background: #fff3e6;">
                            <div class="metric-title">Giảng viên (1)</div>
                            <div class="metric-value" style="color: #f97316;">
                                <?php echo htmlspecialchars($userCount[1] ?? 0); ?>
                            </div>
                        </div>
                        <div class="stat-card-small" style="background: #fee2e2;">
                            <div class="metric-title">Quản trị viên (2)</div>
                            <div class="metric-value" style="color: #ef4444;">
                                <?php echo htmlspecialchars($userCount[2] ?? 0); ?>
                            </div>
                        </div>
                        <div class="stat-card-small">
                            <div class="metric-title">Tổng cộng</div>
                            <div class="metric-value">
                                <?php echo htmlspecialchars(($userCount[0] ?? 0) + ($userCount[1] ?? 0) + ($userCount[2] ?? 0)); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <i class="fas fa-chart-area"></i> Xu hướng Đăng ký (12 tháng gần nhất)
                </div>
                <div class="card-body">
                    <?php if (!empty($enrollmentTrends)): ?>
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>Tháng/Năm</th>
                                    <th>Số lượt Đăng ký</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($enrollmentTrends as $trend): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($trend['month']); ?></td>
                                        <td><?php echo htmlspecialchars($trend['count']); ?> lượt</td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php else: ?>
                        <p>Không có dữ liệu về xu hướng đăng ký trong 12 tháng gần nhất.</p>
                    <?php endif; ?>
                </div>
            </div>

        </main>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.querySelector('.admin-sidebar');
            const toggle = document.querySelector('.sidebar-toggle');

            if (toggle) {
                toggle.addEventListener('click', function() {
                    sidebar.classList.toggle('active');
                });
            }
        });
    </script>
</body>

</html>