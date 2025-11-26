<?php
// Mảng dữ liệu giả lập CSDL
$do_an_list = [
    [
        'id' => 1,
        'ten_de_tai'    => 'Hệ thống quản lý đồ án tốt nghiệp',
        'ten_sinh_vien' => 'Nguyễn Văn A',
        'mssv'          => '20123456',
        'giang_vien_hd' => 'TS. Trần Văn B',
        'nam_hoc'       => '2024-2025',
        'trang_thai'    => 'Đang thực hiện',
        'created_at'    => '2024-11-01 10:00:00'
    ],
    [
        'id' => 2,
        'ten_de_tai'    => 'Ứng dụng AI gợi ý đề tài',
        'ten_sinh_vien' => 'Trần Thị C',
        'mssv'          => '20129876',
        'giang_vien_hd' => 'ThS. Lê Văn D',
        'nam_hoc'       => '2024-2025',
        'trang_thai'    => 'Hoàn thành',
        'created_at'    => '2024-11-05 09:30:00'
    ],
    [
        'id' => 3,
        'ten_de_tai'    => 'Nghiên cứu phát hiện giả giọng nói AI',
        'ten_sinh_vien' => 'Dương Thị N',
        'mssv'          => '20129871',
        'giang_vien_hd' => 'TS. Hoàng Trung K',
        'nam_hoc'       => '2024-2025',
        'trang_thai'    => 'Hoàn thành',
        'created_at'    => '2024-11-10 14:30:00'
    ],
];
function themDoAnMoi($new_do_an)
{
    global $do_an_list;

    // Giả lập tăng ID: Lấy ID lớn nhất hiện tại + 1
    $new_id = 1;
    if (!empty($do_an_list)) {
        // Tìm ID lớn nhất
        $last_do_an = end($do_an_list);
        $new_id = $last_do_an['id'] + 1;
        reset($do_an_list); // Đặt con trỏ mảng về vị trí đầu
    }

    $new_do_an['id'] = $new_id;
    $new_do_an['created_at'] = date('Y-m-d H:i:s');

    // Thêm đồ án mới vào mảng
    $do_an_list[] = $new_do_an;
}
