<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// TODO 10: Import Model SinhVien 
use App\Models\SinhVien;

class SinhVienController extends Controller
{
    // Phương thức index() để lấy danh sách sinh viên
    public function index()
    {
        // TODO 11: Lấy toàn bộ sinh viên bằng Eloquent 
        $danhSachSV = SinhVien::all();
        // TODO 12: Trả về view 'sinhvien.list' và truyền biến $danhSachSV 
        return view('sinhvien.list', compact('danhSachSV'));
    }
    // Phương thức store() để lưu sinh viên mới 
    public function store(Request $request)
    {
        // TODO 13: Lấy toàn bộ dữ liệu từ form gửi lên
        $data = $request->all();
        // TODO 14: Dùng Eloquent ::create() để lưu vào CSDL 
        // Lưu ý: Cần khai báo $fillable trong Model SinhVien trước 
        SinhVien::create($data);
        // TODO 15: Chuyển hướng về trang danh sách sau khi lưu 
        return redirect()->route('sinhvien.index');
    }
}
