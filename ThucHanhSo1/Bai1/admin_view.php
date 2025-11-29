<?php
require_once 'data.php';

// Đường dẫn cơ sở đến thư mục hình ảnh
$image_path = 'images/';
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản Lý Dữ Liệu Các Loài Hoa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .flower-image-table {
            width: 80px;
            height: 80px;
            object-fit: cover;

        }

        .description-column {
            max-width: 300px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }
    </style>
</head>

<body>

    <div class="container mt-2">
        <h1 class="text-center mb-4 text-danger">Quản Lý Danh Sách Các Loài Hoa</h1>

        <div class="mb-3">
            <button type="button" class="btn btn-outline-primary">
                + Thêm
            </button>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered  table-hover align-middle text-center">
                <thead class="table-dark">
                    <tr>
                        <th style="width: 5%;">ID</th>
                        <th style="width: 10%;">Ảnh</th>
                        <th style="width: 15%;">Tên Hoa</th>
                        <th style="width: 55%;">Mô Tả</th>
                        <th style="width: 20%;">Hành Động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php

                    foreach ($flowers as $index => $flower):

                        $first_image = !empty($flower['images']) ? $flower['images'][0] : 'no_image.jpg';

                        $short_description = substr($flower['description'], 0, 1000) . (strlen($flower['description']) > 1000 ? '...' : '');
                    ?>
                        <tr>
                            <th scope="row"><?= $index + 1 ?></th>

                            <td>
                                <?php if (file_exists($image_path . $first_image)): ?>
                                    <img src="<?= $image_path . htmlspecialchars($first_image) ?>"
                                        alt="<?= htmlspecialchars($flower['name']) ?>" class="flower-image-table img-thumbnail">
                                <?php else: ?>
                                    <span class="text-muted small">Không có ảnh</span>
                                <?php endif; ?>
                            </td>

                            <td><?= htmlspecialchars($flower['name']) ?></td>

                            <td>
                                <span title="<?= htmlspecialchars($flower['description']) ?>">
                                    <?= htmlspecialchars($short_description) ?>
                                </span>
                            </td>

                            <td>
                                <a href="edit.php?id=<?= $index ?>" class="btn btn-warning btn-sm">
                                    <i class="bi bi-pencil-square"></i> Sửa
                                </a>
                                <a href="delete.php?id=<?= $index ?>" class="btn btn-danger btn-sm"
                                    onclick="return confirm('Bạn có chắc chắn muốn xóa hoa <?= htmlspecialchars($flower['name']) ?>?')">
                                    <i class="bi bi-trash"></i> Xóa
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <?php if (empty($flowers)): ?>
            <div class="alert alert-info text-center">
                Không có dữ liệu hoa nào để quản lý.
            </div>
        <?php endif; ?>

    </div>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>