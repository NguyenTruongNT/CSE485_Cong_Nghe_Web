@extends('layouts.app') {{-- Kế thừa từ layouts/app.blade.php [cite: 487] --}}

@section('content')
    <h2>Danh sách Sinh viên</h2>

    <form action="{{ route('sinhvien.store') }}" method="POST">
        @csrf {{-- Thêm dòng này ngay dưới thẻ mở form --}}

        Tên sinh viên: <input type="text" name="ten_sinh_vien" required>
        Email: <input type="email" name="email" required>

        <button type="submit">Thêm mới</button>
    </form>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Tên Sinh viên</th>
                <th>Email</th>
            </tr>
        </thead>
        <tbody>
            @foreach($danhSachSV as $sv) {{-- Vòng lặp lấy dữ liệu từ Controller --}}
                <tr>
                    <td>{{ $sv->id }}</td>
                    <td>{{ $sv->ten_sinh_vien }}</td> {{-- In ra dữ liệu an toàn --}}
                    <td>{{ $sv->email }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection