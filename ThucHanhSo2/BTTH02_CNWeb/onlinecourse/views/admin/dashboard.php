<?php
// File: views/admin/dashboard.php
// Dữ liệu cần: $count['total'], $count['student'], $count['instructor'], $count['admin']
// Giả định các biến $count đã được tính toán trong AdminController::dashboard()
// và BASE_URL, $_SESSION['fullname'] đã có.

// Thiết lập các biến nếu chưa tồn tại (để tránh lỗi undefined variable)
$count = $count ?? ['total' => 0, 'student' => 0, 'instructor' => 0, 'admin' => 0];
// Thiết lập biến active menu cho Sidebar
$activeMenu = 'dashboard';
?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - Online Course</title>
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/style.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/admin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    <style>
        /* ================================================= */
        /* CSS CHUNG VÀ BIẾN MÀU SẮC */
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

        /* ================================================= */
        /* NAVBAR (TOP BAR) */
        /* ================================================= */
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

        /* ================================================= */
        /* LAYOUT & SIDEBAR */
        /* ================================================= */
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
        }

        /* Mobile Toggle */
        .sidebar-toggle {
            display: none;
            cursor: pointer;
            font-size: 1.5rem;
            color: var(--primary-color);
            margin-right: 15px;
        }

        /* ================================================= */
        /* CONTENT STYLES */
        /* ================================================= */
        .content-header {
            margin-bottom: 2rem;
            border-bottom: 2px solid var(--gray-border);
            padding-bottom: 1rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .content-header h1 {
            font-size: 1.75rem;
            font-weight: 700;
            color: var(--text-color);
            margin: 0;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .content-header p {
            color: #64748b;
            margin: 0;
        }

        /* Stat Grid */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2.5rem;
        }

        .stat-card {
            background: #fff;
            border-radius: var(--radius-md);
            box-shadow: var(--shadow-md);
            display: flex;
            align-items: center;
            padding: 1.5rem;
            transition: transform 0.2s;
            border-left: 5px solid;
            /* Thêm đường viền màu */
        }

        .stat-card:hover {
            transform: translateY(-5px);
        }

        .stat-icon {
            border-radius: 50%;
            width: 56px;
            height: 56px;
            display: flex;
            justify-content: center;
            align-items: center;
            margin-right: 1rem;
            color: #fff;
            font-size: 1.5rem;
        }

        .stat-info h3 {
            font-size: 12px;
            color: #64748b;
            margin-bottom: 0.25rem;
            text-transform: uppercase;
            font-weight: 600;
        }

        .stat-number {
            font-size: 28px;
            font-weight: 800;
            color: var(--text-color);
        }

        /* Colors for stat icons */
        .stat-card.primary {
            border-color: var(--primary-color);
        }

        .stat-card.success {
            border-color: #10b981;
        }

        .stat-card.warning {
            border-color: #f59e0b;
        }

        .stat-card.danger {
            border-color: #ef4444;
        }

        .stat-card.primary .stat-icon {
            background-color: var(--primary-color);
        }

        .stat-card.success .stat-icon {
            background-color: #10b981;
        }

        .stat-card.warning .stat-icon {
            background-color: #f59e0b;
        }

        .stat-card.danger .stat-icon {
            background-color: #ef4444;
        }

        /* Card (general container) */
        .card {
            background: #fff;
            border-radius: var(--radius-md);
            box-shadow: var(--shadow-md);
            margin-bottom: 2rem;
            border: 1px solid var(--gray-border);
        }

        .card-header {
            padding: 1rem 1.5rem;
            border-bottom: 1px solid var(--gray-border);
            font-weight: 600;
            font-size: 1.1rem;
            color: var(--text-color);
        }

        .card-body {
            padding: 1.5rem;
        }

        /* Buttons */
        .btn-action-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
        }

        .btn-outline,
        .btn-primary-custom {
            padding: 10px 15px;
            border-radius: 6px;
            text-decoration: none;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            transition: all 0.2s;
            font-weight: 600;
            border: 1px solid;
        }

        .btn-outline {
            border-color: var(--primary-color);
            color: var(--primary-color);
            background: #fff;
        }

        .btn-outline:hover {
            background: var(--primary-light);
        }

        .btn-primary-custom {
            background: var(--primary-color);
            color: white;
            border-color: var(--primary-color);
        }

        .btn-primary-custom:hover {
            background: #3730a3;
            border-color: #3730a3;
        }

        .btn-danger-custom {
            background: #ef4444;
            color: white;
            padding: 5px 10px;
            text-decoration: none;
            border-radius: 4px;
            transition: background 0.2s;
        }

        .btn-danger-custom:hover {
            background: #dc2626;
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
                margin-top: 60px;
                /* Bù trừ cho navbar fixed */
            }
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
                <div>
                    <h1><i class="fas fa-chart-line"></i> Dashboard</h1>
                    <p>Tổng quan về hệ thống và các chỉ số chính</p>
                </div>
            </div>

            <div class="stats-grid">
                <div class="stat-card primary">
                    <div class="stat-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="stat-info">
                        <h3>Tổng người dùng</h3>
                        <div class="stat-number"><?php echo $count['total']; ?></div>
                    </div>
                </div>

                <div class="stat-card success">
                    <div class="stat-icon">
                        <i class="fas fa-user-graduate"></i>
                    </div>
                    <div class="stat-info">
                        <h3>Học viên</h3>
                        <div class="stat-number"><?php echo $count['student']; ?></div>
                    </div>
                </div>

                <div class="stat-card warning">
                    <div class="stat-icon">
                        <i class="fas fa-chalkboard-teacher"></i>
                    </div>
                    <div class="stat-info">
                        <h3>Giảng viên</h3>
                        <div class="stat-number"><?php echo $count['instructor']; ?></div>
                    </div>
                </div>

                <div class="stat-card danger">
                    <div class="stat-icon">
                        <i class="fas fa-user-shield"></i>
                    </div>
                    <div class="stat-info">
                        <h3>Quản trị viên</h3>
                        <div class="stat-number"><?php echo $count['admin']; ?></div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <i class="fas fa-bolt me-2"></i> Hành động nhanh
                </div>
                <div class="card-body">
                    <div class="btn-action-grid">
                        <a href="<?php echo BASE_URL; ?>/admin/users" class="btn-outline">
                            <i class="fas fa-users"></i> Quản lý người dùng
                        </a>
                        <a href="<?php echo BASE_URL; ?>/admin/categories" class="btn-outline">
                            <i class="fas fa-list"></i> Quản lý danh mục
                        </a>
                        <a href="<?php echo BASE_URL; ?>/admin/courseApproval" class="btn-outline">
                            <i class="fas fa-check-circle"></i> Duyệt khóa học
                        </a>
                        <a href="<?php echo BASE_URL; ?>/admin/systemStatistics" class="btn-outline">
                            <i class="fas fa-chart-bar"></i> Thống kê Hệ thống
                        </a>
                        <a href="<?php echo BASE_URL; ?>/" class="btn-primary-custom">
                            <i class="fas fa-home"></i> Về trang chủ
                        </a>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <i class="fas fa-history me-2"></i> Hoạt động gần đây
                </div>
                <div class="card-body">
                    <p>Không có dữ liệu hoạt động gần đây.</p>
                </div>
            </div>
        </main>
    </div>

    <script>
        // Bật/tắt Sidebar trên mobile
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