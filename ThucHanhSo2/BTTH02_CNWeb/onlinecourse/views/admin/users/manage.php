<?php
// File: views/admin/users/manage.php
// Hiển thị danh sách người dùng (users) để Quản trị viên quản lý.
// Dữ liệu cần: $users (Danh sách user từ User Model)
// Giả định BASE_URL, $_SESSION['fullname'], $_SESSION['user_role'] đã có.
$users = $users ?? [];
// Bổ sung biến active menu cho Sidebar, đặt là 'users'
$activeMenu = 'users';
?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý Người dùng - Admin</title>
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/style.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/admin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    <style>
        /* ================================================= */
        /* CSS CHUNG VÀ BIẾN MÀU SẮC (Được dùng cho Dashboard) */
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
        /* NAVBAR (TOP BAR) - Áp dụng style Dashboard */
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

        /* Thêm style cho nút Đăng xuất (dùng trong navbar) */
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
        }

        .btn-danger-custom:hover {
            background: #dc2626;
        }

        /* ================================================= */
        /* LAYOUT & SIDEBAR - Áp dụng style Dashboard */
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
            background-color: var(--gray-light);
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
        /* CONTENT STYLES (GIỮ NGUYÊN HOÀN TOÀN CẤU TRÚC GỐC) */
        /* ================================================= */
        .content-header {
            margin-bottom: 20px;
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


        .user-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .user-table th,
        .user-table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #e2e8f0;
            font-size: 14px;
            vertical-align: middle;
        }

        .user-table th {
            background-color: var(--primary-light);
            color: var(--primary-color);
            font-weight: 600;
        }

        .user-table tbody tr:hover {
            background-color: #f8fafc;
        }

        .badge {
            padding: 5px 10px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: 600;
            text-transform: capitalize;
        }

        .badge-admin {
            background-color: #fecaca;
            color: #dc2626;
        }

        .badge-instructor {
            background-color: #fde68a;
            color: #b45309;
        }

        .badge-student {
            background-color: #dbeafe;
            color: #2563eb;
        }

        .badge-active {
            background-color: #d1fae5;
            color: #059669;
        }

        .badge-inactive {
            background-color: #ffe4e6;
            color: #be123c;
        }

        .action-btn {
            color: #4f46e5;
            margin-left: 5px;
            text-decoration: none;
            padding: 5px;
            border-radius: 4px;
            transition: background 0.3s;
        }

        .action-btn:hover {
            background: #eef2ff;
        }

        .btn-delete {
            color: #ef4444;
        }

        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 8px;
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
                <h1><i class="fas fa-users"></i> Quản lý Người dùng</h1>
                <p>Xem, kích hoạt và vô hiệu hóa tài khoản người dùng.</p>
            </div>


            <?php if (isset($_GET['msg'])): ?>
                <div class="alert alert-success" style="background-color: #d4edda; color: #155724;">
                    <?php echo htmlspecialchars($_GET['msg']); ?>
                </div>
            <?php endif; ?>

            <?php if (!empty($users)): ?>
                <div style="overflow-x: auto;">
                    <table class="user-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Họ & Tên</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Trạng thái</th>
                                <th>Ngày tạo</th>
                                <th style="width: 150px;">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($users as $user): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($user['id']); ?></td>
                                    <td><?php echo htmlspecialchars($user['fullname'] ?: $user['username']); ?></td>
                                    <td><?php echo htmlspecialchars($user['email']); ?></td>
                                    <td>
                                        <?php
                                        $role = $user['role'];
                                        $role_text = 'Học viên';
                                        $role_class = 'badge-student';
                                        if ($role == 1) {
                                            $role_text = 'Giảng viên';
                                            $role_class = 'badge-instructor';
                                        }
                                        if ($role == 2) {
                                            $role_text = 'Quản trị viên';
                                            $role_class = 'badge-admin';
                                        }
                                        ?>
                                        <span class="badge <?php echo $role_class; ?>"><?php echo $role_text; ?></span>
                                    </td>
                                    <td>
                                        <?php
                                        $status = $user['status'];
                                        $status_text = $status == 1 ? 'Hoạt động' : 'Bị khóa';
                                        $status_class = $status == 1 ? 'badge-active' : 'badge-inactive';
                                        ?>
                                        <span class="badge <?php echo $status_class; ?>"><?php echo $status_text; ?></span>
                                    </td>
                                    <td><?php echo date('d/m/Y', strtotime($user['created_at'])); ?></td>
                                    <td>
                                        <a href="<?php echo BASE_URL; ?>/admin/toggleStatus/<?php echo $user['id']; ?>"
                                            class="action-btn"
                                            title="<?php echo $status == 1 ? 'Vô hiệu hóa' : 'Kích hoạt'; ?>">
                                            <i class="fas <?php echo $status == 1 ? 'fa-lock' : 'fa-unlock'; ?>"></i>
                                        </a>

                                        <a href="<?php echo BASE_URL; ?>/admin/deleteUser/<?php echo $user['id']; ?>"
                                            class="action-btn btn-delete"
                                            onclick="return confirm('Bạn có chắc chắn muốn xóa user <?php echo htmlspecialchars($user['username']); ?>?');"
                                            title="Xóa người dùng">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <div class="alert alert-info" style="padding: 15px; background-color: #f0f8ff; border: 1px solid #b3e5fc;">
                    Chưa có người dùng nào được đăng ký trong hệ thống.</div>
            <?php endif; ?>
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