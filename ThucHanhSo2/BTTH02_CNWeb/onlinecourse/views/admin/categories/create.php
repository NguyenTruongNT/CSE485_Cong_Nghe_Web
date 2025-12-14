<?php
// File: views/admin/categories/create.php
$category = $category ?? [];
// Thiết lập biến active menu cho Sidebar
$activeMenu = 'categories';
?>
<!DOCTYPE html>
<html lang="vi">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm Danh mục - Admin</title>

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
            max-width: 800px;
            /* Giữ nguyên max-width từ file gốc */
            margin: 0 auto;
            /* Căn giữa content nếu max-width nhỏ hơn màn hình */
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

        .sidebar-item i {
            margin-right: 10px;
        }

        .content-header h1 {
            color: var(--text-color);
            border-bottom: 2px solid var(--gray-border);
            padding-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 1.75rem;
            font-weight: 700;
            margin: 0 0 2rem 0;
        }

        .card {
            background: #fff;
            border-radius: var(--radius-md);
            box-shadow: var(--shadow-md);
            margin-bottom: 2rem;
        }

        .card-body {
            padding: 1.5rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 600;
            color: var(--text-color);
        }

        .form-control {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 6px;
            box-sizing: border-box;
        }

        .btn-secondary {
            background: #6b7280;
            color: white;
            padding: 8px 15px;
            border-radius: 6px;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 5px;
            transition: background 0.3s;
            border: none;
        }

        .btn-secondary:hover {
            background: #4b5563;
        }

        .btn-primary {
            background: var(--primary-color);
            color: white;
            padding: 10px 15px;
            border-radius: 6px;
            border: none;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 5px;
            transition: background 0.3s;
        }

        .btn-primary:hover {
            background: #3730a3;
        }

        .alert-error {
            background-color: #f8d7da;
            color: #721c24;
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 4px;
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
                <h1><i class="fas fa-plus-circle"></i> Thêm Danh mục mới</h1>
                <p>Điền thông tin để tạo danh mục khóa học.</p>
            </div>

            <a href="<?php echo BASE_URL; ?>/admin/categories" class="btn btn-secondary" style="margin-bottom: 20px;">
                <i class="fas fa-arrow-left"></i> Quay lại Danh sách
            </a>

            <?php if (isset($_GET['msg'])): ?>
                <div class="alert alert-error">
                    <?php echo htmlspecialchars($_GET['msg']); ?>
                </div>
            <?php endif; ?>

            <div class="card">
                <div class="card-body">
                    <form action="<?php echo BASE_URL; ?>/admin/storeCategory" method="POST">
                        <div class="form-group">
                            <label for="name">Tên Danh mục (*)</label>
                            <input type="text" id="name" name="name" required class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="description">Mô tả</label>
                            <textarea id="description" name="description" rows="4" class="form-control"></textarea>
                        </div>

                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Lưu Danh mục
                        </button>
                    </form>
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