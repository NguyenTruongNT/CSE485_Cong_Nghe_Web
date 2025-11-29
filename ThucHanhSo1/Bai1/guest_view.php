<?php
// 1. Nhúng tệp dữ liệu
require_once 'data.php';

// Đường dẫn cơ sở đến thư mục hình ảnh
$image_path = 'images/';
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>14 loại hoa tuyệt đẹp thích hợp trồng để khoe hương sắc dịp xuân hè</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .flower-image {
            max-width: 100%;
            height: auto;
            display: block;
            margin: 0 auto 1.5rem auto;
        }

        .flower-article {
            margin-bottom: 2.5rem;
        }

        .container-md {
            width: 900px;
        }
    </style>
</head>

<body>

    <div class="container-md mt-5">
        <h1 class="mb-5">14 loại hoa tuyệt đẹp thích hợp trồng để khoe hương sắc dịp xuân hè
        </h1>
        <div>
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
            <img src="images/hoadep.jpg" alt="" class="flower-image">
        </div>



        <?php foreach ($flowers as $index => $flower): ?>
            <div class="flower-article" style="font-size: 1rem; line-height: 1.6;">
                <h4 class="mb-3 fw-bold">
                    <?php echo $index + 1; ?>.
                    <?php echo $flower['name']; ?>
                </h4>

                <p class="text-justify"><?php echo $flower['description']; ?></p>

                <div class=""> <?php

                                if (isset($flower['images'])) {
                                    foreach ($flower['images'] as $image_filename):
                                        $image_src = $image_path . $image_filename;
                                        if (file_exists($image_src)):
                                ?>
                                <div class="text-center"> <img src="<?php echo $image_src; ?>"
                                        alt="Hình ảnh <?php echo $flower['name']; ?>" class="flower-image">
                                </div>
                            <?php else: ?>
                                <div class="alert alert-warning text-center">
                                    <i class="bi bi-exclamation-triangle-fill"></i> Không tìm thấy ảnh:
                                    <?php echo $image_filename; ?>
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

        <?php if (empty($flowers)): ?>
            <div class="alert alert-info text-center">
                Chưa có dữ liệu về các loài hoa nào được thêm vào.
            </div>
        <?php endif; ?>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>