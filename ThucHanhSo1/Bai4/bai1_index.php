<?php
require_once 'db_connect.php';
$image_path = '../Bai1/images/';
$mode = isset($_GET['mode']) && $_GET['mode'] === 'admin' ? 'admin' : 'guest';

$action = isset($_GET['action']) ? $_GET['action'] : 'read';
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

$flowers = [];
$flower_data = [];
$error_message = '';
$success_message = '';
$page_title = '';

function safe_html($data)
{
    return htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
}

function redirect($message = '')
{
    $url = 'bai1_index.php?mode=admin';
    if ($message) {
        $url .= '&msg=' . urlencode($message);
    }
    header('Location: ' . $url);
    exit;
}

if (isset($_GET['msg'])) {
    $success_message = safe_html($_GET['msg']);
}


if ($mode === 'admin' && $action === 'delete' && $id > 0) {
    try {
        $stmt = $conn->prepare("DELETE FROM flowers WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        redirect('Xóa hoa thành công!');
    } catch (PDOException $e) {
        $error_message = "Lỗi xóa dữ liệu: " . $e->getMessage();
        $action = 'read';
    }
}

if ($mode === 'admin' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = isset($_POST['flower_name']) ? trim($_POST['flower_name']) : '';
    $description = isset($_POST['description']) ? trim($_POST['description']) : '';
    $image_path_input = isset($_POST['image_path']) ? trim($_POST['image_path']) : '';
    $record_id = isset($_POST['id']) ? (int)$_POST['id'] : 0;

    if (empty($name) || empty($description)) {
        $error_message = "Tên hoa và mô tả không được để trống.";
        $action = $record_id > 0 ? 'edit' : 'add';
    } else {
        if ($record_id > 0) {
            try {
                $stmt = $conn->prepare("UPDATE flowers SET flower_name = :name, description = :description, image_path = :path WHERE id = :id");
                $stmt->bindParam(':name', $name);
                $stmt->bindParam(':description', $description);
                $stmt->bindParam(':path', $image_path_input);
                $stmt->bindParam(':id', $record_id, PDO::PARAM_INT);
                $stmt->execute();
                redirect('Cập nhật hoa thành công!');
            } catch (PDOException $e) {
                $error_message = "Lỗi cập nhật dữ liệu: " . $e->getMessage();
                $action = 'edit';
            }
        } else {
            try {
                $stmt = $conn->prepare("INSERT INTO flowers (flower_name, description, image_path) VALUES (:name, :description, :path)");
                $stmt->bindParam(':name', $name);
                $stmt->bindParam(':description', $description);
                $stmt->bindParam(':path', $image_path_input);
                $stmt->execute();
                redirect('Thêm hoa mới thành công!');
            } catch (PDOException $e) {
                $error_message = "Lỗi thêm mới dữ liệu: " . $e->getMessage();
                $action = 'add';
            }
        }
    }
}


if ($mode === 'admin' && $action === 'edit' && $id > 0) {
    try {
        $stmt = $conn->prepare("SELECT id, flower_name, description, image_path FROM flowers WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $flower_data = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$flower_data) {
            $error_message = "Không tìm thấy bản ghi cần chỉnh sửa.";
            $action = 'read';
        }
    } catch (PDOException $e) {
        $error_message = "Lỗi truy vấn dữ liệu: " . $e->getMessage();
        $action = 'read';
    }
}

if ($action === 'read' || $mode === 'guest' || $error_message) {
    try {
        $sql = "SELECT id, flower_name, description, image_path FROM flowers ORDER BY id ASC";
        $stmt = $conn->query($sql);
        $flowers_db = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($flowers_db as $item) {
            $images = array_map('trim', explode(',', $item['image_path']));

            $flowers[] = [
                'id' => $item['id'],
                'name' => $item['flower_name'],
                'description' => $item['description'],
                'images' => array_filter($images)
            ];
        }

        if (empty($flowers) && empty($error_message)) {
            $error_message = "Không có dữ liệu hoa nào trong CSDL.";
        }
    } catch (PDOException $e) {
        $error_message = "Lỗi truy vấn CSDL: " . $e->getMessage();
    }
}
$page_title = ($mode === 'admin')
    ? ($action === 'add' ? 'Thêm Hoa Mới' : ($action === 'edit' ? 'Chỉnh Sửa Hoa' : 'Quản Lý Dữ Liệu Các Loài Hoa'))
    : '14 loại hoa tuyệt đẹp thích hợp trồng để khoe hương sắc dịp xuân hè';

function get_first_image($flower)
{
    return !empty($flower['images']) ? $flower['images'][0] : 'no_image.jpg';
}
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo safe_html($page_title); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    <style>
        <?php if ($mode === 'admin'): ?>.flower-image-table {
            width: 80px;
            height: 80px;
            object-fit: cover;
        }

        .table-responsive table {
            table-layout: fixed;
        }

        <?php else: ?>.flower-image {
            max-width: 100%;
            height: auto;
            display: block;
            margin: 0 auto 1.5rem auto;
        }

        .flower-article {
            margin-bottom: 2.5rem;
        }

        .container-main {
            max-width: 900px;
        }

        <?php endif;
        ?>
    </style>
</head>

<body>

    <?php
    if (!empty($error_message)): ?>
        <div class="container mt-4">
            <div class="alert alert-danger" role="alert">
                <i class="bi bi-x-circle-fill"></i> LỖI: <?php echo safe_html($error_message); ?>
            </div>
        </div>
    <?php endif; ?>

    <?php
    if (!empty($success_message)): ?>
        <div class="container mt-4">
            <div class="alert alert-success" role="alert">
                <i class="bi bi-check-circle-fill"></i> Thành công! <?php echo safe_html($success_message); ?>
            </div>
        </div>
    <?php endif; ?>


    <?php if ($mode === 'admin'): ?>
        <div class="container mt-2">
            <h1 class="text-center mb-4 text-danger"><?php echo safe_html($page_title); ?></h1>

            <div class="mb-3 d-flex justify-content-between">
                <a href="?mode=admin&action=add" class="btn btn-outline-primary <?= $action === 'add' ? 'disabled' : '' ?>">
                    <i class="bi bi-plus-circle"></i> Thêm mới
                </a>

                <a href="?mode=guest" class="btn btn-outline-info">
                    <i class="bi bi-eye"></i> Xem giao diện khách
                </a>
            </div>

            <?php

            if ($action === 'add' || ($action === 'edit' && $flower_data)):
                $is_edit = ($action === 'edit');
                $form_data = $is_edit ? $flower_data : ['id' => 0, 'flower_name' => '', 'description' => '', 'image_path' => ''];
            ?>
                <div class="card shadow-sm mb-5">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">
                            <?= $is_edit ? 'Chỉnh Sửa Hoa: ' . safe_html($form_data['flower_name']) : 'Thêm Hoa Mới' ?></h5>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="?mode=admin">
                            <input type="hidden" name="id" value="<?= safe_html($form_data['id']) ?>">

                            <div class="mb-3">
                                <label for="flower_name" class="form-label">Tên Hoa <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="flower_name" name="flower_name"
                                    value="<?= safe_html($form_data['flower_name']) ?>" required>
                            </div>

                            <div class="mb-3">
                                <label for="description" class="form-label">Mô Tả <span class="text-danger">*</span></label>
                                <textarea class="form-control" id="description" name="description" rows="5"
                                    required><?= safe_html($form_data['description']) ?></textarea>
                            </div>

                            <div class="mb-3">
                                <label for="image_path" class="form-label">Tên File Ảnh (VD: hoadai.jpg,hoanho.jpg)</label>
                                <input type="text" class="form-control" id="image_path" name="image_path"
                                    value="<?= safe_html($form_data['image_path']) ?>"
                                    placeholder="Nếu có nhiều ảnh, cách nhau bằng dấu phẩy">
                            </div>

                            <div class="d-flex justify-content-end">
                                <button type="submit" class="btn btn-success me-2">
                                    <i class="bi bi-check-circle"></i> <?= $is_edit ? 'Lưu Thay Đổi' : 'Thêm' ?>
                                </button>
                                <a href="?mode=admin" class="btn btn-secondary">Hủy</a>
                            </div>
                        </form>
                    </div>
                </div>

            <?php
            elseif ($action === 'read'): ?>
                <?php if (empty($flowers)): ?>
                    <?php if (empty($error_message)): ?>
                        <div class="alert alert-info text-center">
                            Không có dữ liệu hoa nào để quản lý.
                        </div>
                    <?php endif; ?>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover align-middle text-center">
                            <thead class="table-dark">
                                <tr>
                                    <th style="width: 5%;">STT</th>
                                    <th style="width: 10%;">Ảnh</th>
                                    <th style="width: 15%;">Tên Hoa</th>
                                    <th style="width: 50%;">Mô Tả</th>
                                    <th style="width: 20%;">Hành Động</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($flowers as $index => $flower):
                                    $stt = $index + 1;
                                    $first_image = get_first_image($flower);
                                    $short_description = substr($flower['description'], 0, 1000) . (strlen($flower['description']) > 1000 ? '...' : '');
                                ?>
                                    <tr>
                                        <th scope="row"><?= $stt ?></th>

                                        <td>
                                            <?php
                                            $image_file_path = str_replace('../Bai1/', '', $image_path) . $first_image;
                                            if (file_exists($image_file_path)): ?>
                                                <img src="<?= safe_html($image_path . $first_image) ?>"
                                                    alt="<?= safe_html($flower['name']) ?>" class="flower-image-table img-thumbnail">
                                            <?php else: ?>
                                                <span class="text-muted small">Không có ảnh</span>
                                            <?php endif; ?>
                                        </td>

                                        <td><?= safe_html($flower['name']) ?></td>

                                        <td class="description-column" title="<?= safe_html($flower['description']) ?>">
                                            <?= safe_html($short_description) ?>
                                        </td>

                                        <td>
                                            <a href="?mode=admin&action=edit&id=<?= $flower['id'] ?>"
                                                class="btn btn-warning btn-sm mb-1">
                                                <i class="bi bi-pencil-square"></i> Sửa
                                            </a>
                                            <a href="?mode=admin&action=delete&id=<?= $flower['id'] ?>" class="btn btn-danger btn-sm"
                                                onclick="return confirm('Bạn có chắc chắn muốn xóa hoa <?= safe_html($flower['name']) ?>?')">
                                                <i class="bi bi-trash"></i> Xóa
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>

            <?php endif; ?>

        </div>

    <?php else: ?>
        <div class="container-main container-md mt-5">
            <h1 class="mb-5 text-center">
                14 loại hoa tuyệt đẹp thích hợp trồng để khoe hương sắc dịp xuân hè
            </h1>

            <div class="mb-4 d-flex justify-content-end">
                <a href="?mode=admin" class="btn btn-outline-info">
                    <i class="bi bi-gear"></i> Chuyển sang Quản trị
                </a>
            </div>
            <h5 class="fw-bold mb-2">
                Hãy nhanh chóng ghi vào sổ tay của bạn 14 loài hoa tuyệt đẹp để lên kế hoạch trồng chúng trong
                dịp xuân - hè này nhé!
            </h5>
            <ul class="list-unstyled">
                <li class="mb-2">
                    <span class="text-danger me-2" style="font-size: 1.2rem;">•</span>
                    <a href="#" class="text-decoration-none text-dark">
                        Cách trồng hoa thạch lan đẹp lạ để trang trí bàn làm việc thêm hút mắt
                    </a>
                    <span class="text-muted ms-1 small" aria-hidden="true">&#x2197;</span>
                </li>
                <li class="mb-2">
                    <span class="text-danger me-2" style="font-size: 1.2rem;">•</span>
                    <a href="#" class="text-decoration-none text-dark">
                        9 loại hoa trồng trong chậu đẹp ngất ngây cho mùa xuân
                    </a>
                    <span class="text-muted ms-1 small" aria-hidden="true">&#x2197;</span>
                </li>
                <li class="mb-2">
                    <span class="text-danger me-2" style="font-size: 1.2rem;">•</span>
                    <a href="#" class="text-decoration-none text-dark">
                        Sân vườn cực đẹp với 5 loại hoa hồng ngoại dễ trồng
                    </a>
                    <span class="text-muted ms-1 small" aria-hidden="true">&#x2197;</span>
                </li>
            </ul>

            <hr class="my-4">

            <p class="lead" style="font-size: 1rem; line-height: 1.6;">
                Mỗi
                <strong class="text-primary">loại hoa</strong>
                sẽ khoe sắc rực rỡ vào đúng thời điểm thích hợp trong năm, khí hậu đáp ứng thuận lợi sẽ giúp hoa
                phát triển nhanh và đẹp một cách hoàn hảo. Nếu đang có kế hoạch trồng hoa trong dịp xuân - hè
                thì bạn hãy tham khảo bài viết dưới đây nhé!
            </p>

            <?php if (empty($flowers)): ?>
                <?php if (empty($error_message)): ?>
                    <div class="alert alert-info text-center">
                        Chưa có dữ liệu về các loài hoa nào được thêm vào.
                    </div>
                <?php endif; ?>
            <?php else: ?>
                <div>
                    <img src="images/hoadep.jpg" alt="Ảnh minh họa các loài hoa" class="flower-image">
                </div>

                <?php foreach ($flowers as $index => $flower): ?>
                    <div class="flower-article" style="font-size: 1rem; line-height: 1.6;">
                        <h4 class="mb-3 fw-bold">
                            <?php echo $index + 1; ?>.
                            <?php echo safe_html($flower['name']); ?>
                        </h4>

                        <p class="text-justify"><?php echo nl2br(safe_html($flower['description'])); ?></p>

                        <div class="">
                            <?php
                            if (isset($flower['images'])) {
                                foreach ($flower['images'] as $image_filename):

                                    if (empty($image_filename)) continue;

                                    $image_src = $image_path . $image_filename;
                                    $image_file_path = str_replace('../Bai1/', '', $image_path) . $image_filename;
                                    if (file_exists($image_file_path)):
                            ?>
                                        <div class="text-center">
                                            <img src="<?php echo safe_html($image_src); ?>"
                                                alt="Hình ảnh <?php echo safe_html($flower['name']); ?>"
                                                class="flower-image img-fluid rounded shadow-sm">
                                        </div>
                                    <?php else: ?>
                                        <div class="alert alert-warning text-center">
                                            <i class="bi bi-exclamation-triangle-fill"></i> Không tìm thấy ảnh:
                                            <?php echo safe_html($image_filename); ?>
                                        </div>
                                    <?php endif; ?>
                            <?php endforeach;
                            }
                            ?>
                        </div>

                        <?php if ($index < count($flowers) - 1): ?>
                            <hr class="mt-5 mb-5">
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

    <?php endif; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>