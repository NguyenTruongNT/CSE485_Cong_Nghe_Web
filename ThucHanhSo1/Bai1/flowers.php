<?php
require_once 'data.php';
// Biến kiểm tra chế độ hiển thị (true = Quản trị, false = Khách)
$isAdmin = false;

?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?= $isAdmin ? 'Quản Lý Dữ Liệu Các Loài Hoa' : '14 loại hoa tuyệt đẹp thích hợp trồng để khoe hương sắc dịp xuân hè' ?>
    </title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        .flower-image-card {
            height: 200px;
            object-fit: cover;
        }

        .flower-image-table {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 5px;
        }
    </style>
</head>

<body>

    <div class="container mt-5">
        <h1 class="text-center mb-5">
        </h1>

        <?php if ($isAdmin): ?>
            <?php include 'admin_view.php'; ?>
        <?php else: ?>
            <?php include 'guest_view.php'; ?>
        <?php endif; ?>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
</body>

</html>