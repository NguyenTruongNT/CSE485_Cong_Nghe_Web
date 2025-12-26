<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chi tiết Nhân viên</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow">
                    <div class="card-header bg-info text-white">
                        <h4 class="mb-0">Thông tin chi tiết nhân viên</h4>
                    </div>
                    <div class="card-body">
                        <table class="table table-borderless">
                            <tr>
                                <th width="40%">Mã nhân viên:</th>
                                <td>{{ $employee->id }}</td>
                            </tr>
                            <tr>
                                <th>Tên nhân viên:</th>
                                <td>{{ $employee->name }}</td>
                            </tr>
                            <tr>
                                <th>Email:</th>
                                <td>{{ $employee->email }}</td>
                            </tr>
                            <tr>
                                <th>Số điện thoại:</th>
                                <td>{{ $employee->phone ?? 'Chưa cập nhật' }}</td>
                            </tr>
                            <tr>
                                <th>Phòng ban:</th>
                                <td>{{ $employee->department->name }}</td>
                            </tr>
                            <tr>
                                <th>Chức vị:</th>
                                <td><span class="badge bg-secondary">{{ $employee->position }}</span></td>
                            </tr>
                            <tr>
                                <th>Lương:</th>
                                <td>{{ number_format($employee->salary, 2) }} VNĐ</td>
                            </tr>
                        </table>
                        <hr>
                        <div class="text-end">
                            <a href="{{ route('employees.index') }}" class="btn btn-secondary">Quay lại danh sách</a>
                            <a href="{{ route('employees.edit', $employee->id) }}" class="btn btn-warning">Chỉnh sửa</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>