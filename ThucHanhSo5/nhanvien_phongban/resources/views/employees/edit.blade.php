<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chỉnh sửa Nhân viên</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow">
                    <div class="card-header bg-warning text-dark">
                        <h4 class="mb-0">Cập nhật thông tin nhân viên</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('employees.update', $employee->id) }}" method="POST">
                            @csrf
                            @method('PUT') <div class="mb-3">
                                <label class="form-label">Tên nhân viên</label>
                                <input type="text" name="name" class="form-control" value="{{ $employee->name }}"
                                    required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" name="email" class="form-control" value="{{ $employee->email }}"
                                    required>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Điện thoại</label>
                                    <input type="text" name="phone" class="form-control" value="{{ $employee->phone }}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Phòng ban</label>
                                    <select name="department_id" class="form-select">
                                        @foreach($departments as $dept)
                                            <option value="{{ $dept->id }}" {{ $employee->department_id == $dept->id ? 'selected' : '' }}>
                                                {{ $dept->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Chức vị</label>
                                    <select name="position" class="form-select">
                                        <option value="Staff" {{ $employee->position == 'Staff' ? 'selected' : '' }}>Staff
                                        </option>
                                        <option value="Manager" {{ $employee->position == 'Manager' ? 'selected' : '' }}>
                                            Manager</option>
                                        <option value="VP" {{ $employee->position == 'VP' ? 'selected' : '' }}>VP</option>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Lương</label>
                                    <input type="number" step="0.01" name="salary" class="form-control"
                                        value="{{ $employee->salary }}" required>
                                </div>
                            </div>

                            <div class="text-end">
                                <a href="{{ route('employees.index') }}" class="btn btn-secondary">Quay lại</a>
                                <button type="submit" class="btn btn-primary">Cập nhật</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>