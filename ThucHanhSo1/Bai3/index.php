<?php

$file_path = './65HTTT_Danh_sach_diem_danh.csv';

$csv_data = [];
$header = [];
$is_first_row = true;

if (!file_exists($file_path)) {
    die("Lỗi: Tệp CSV không tồn tại tại đường dẫn: " . htmlspecialchars($file_path));
}
if (($handle = fopen($file_path, "r")) !== FALSE) {
    while (($row = fgetcsv($handle, 1000, ",")) !== FALSE) {
        if ($is_first_row) {
            $header = $row;
            $is_first_row = false;
        } else {
            $csv_data[] = $row;
        }
    }
    fclose($handle);
} else {
    die("Lỗi: Không thể mở tệp CSV để đọc.");
}
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hiển Thị Nội Dung Tệp CSV</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

    <div class="container mt-5">

        <h1 class="text-primary mb-4 text-center">Danh Sách Tài Khoản</h1>

        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover align-middle">

                <thead>
                    <tr class="table-primary">
                        <?php foreach ($header as $col_name): ?>
                            <th scope="col"><?php echo htmlspecialchars($col_name); ?></th>
                        <?php endforeach; ?>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach ($csv_data as $row): ?>
                        <tr>
                            <?php foreach ($row as $cell): ?>
                                <td><?php echo htmlspecialchars($cell); ?></td>
                            <?php endforeach; ?>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <?php if (empty($csv_data)): ?>
            <div class="alert alert-warning text-center mt-4" role="alert">
                Tệp CSV không chứa dữ liệu.
            </div>
        <?php endif; ?>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>