<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý Sinh Viên</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body class="bg-light">
    <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2 class="text-primary">Danh sách Sinh viên</h2>
            <a href="{{ route('students.create') }}" class="btn btn-success">Thêm sinh viên mới</a>
        </div>

        <form action="{{ route('students.index') }}" method="GET" class="mb-3 d-flex">
            <input type="text" name="search" class="form-control me-2" placeholder="Tìm theo tên hoặc email..."
                value="{{ request('search') }}"> <button type="submit" class="btn btn-outline-primary">Tìm</button>
        </form>

        @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div> @endif

        <div class="table-responsive">
            <table class="table table-bordered table-striped align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>Mã SV</th>
                        <th>Tên sinh viên</th>
                        <th>Email</th>
                        <th>Số điện thoại</th>
                        <th>Ngày sinh</th>
                        <th>Tên lớp học</th>
                        <th>Giới tính</th>
                        <th>Trạng thái</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($students as $emp)
                        <tr>
                            <td>{{ $emp->student_code }}</td>
                            <td>{{ $emp->name }}</td>
                            <td>{{ $emp->email }}</td>
                            <td>{{ $emp->phone }}</td>
                            <td>{{ $emp->date_of_birth }}</td>
                            <td>{{ $emp->class->name }}</td>
                            <td>{{ $emp->gender}}</td>
                            <td>{{ $emp->status }}</td>

                            <td>
                                <a href="{{ route('students.show', $emp->id) }}" class="btn btn-sm btn-info">Xem</a>
                                <a href="{{ route('students.edit', $emp->id) }}" class="btn btn-sm btn-warning">Sửa</a>

                                <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal"
                                    data-bs-target="#deleteModal{{ $emp->id }}">
                                    Xóa
                                </button>

                                <div class="modal fade" id="deleteModal{{ $emp->id }}" tabindex="-1"
                                    aria-labelledby="deleteModalLabel{{ $emp->id }}" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="deleteModalLabel{{ $emp->id }}">Xác nhận xóa
                                                </h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                Bạn có chắc chắn muốn xóa nhân viên <strong>{{ $emp->name }}</strong> không?

                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Hủy</button>
                                                <form action="{{ route('students.destroy', $emp->id) }}" method="POST"
                                                    style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger">Xác nhận Xóa</button>

                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-center">
            {{ $students->appends(request()->query())->links('pagination::bootstrap-5') }}
        </div>
    </div>
</body>

</html>