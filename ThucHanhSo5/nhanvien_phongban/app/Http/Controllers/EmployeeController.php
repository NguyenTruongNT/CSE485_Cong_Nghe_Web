<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Department;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    /**
     * Hiển thị danh sách nhân viên kèm phân trang.
     */
    public function index(Request $request)
    {
        // Lấy từ khóa từ ô input có name="search"
        $search = $request->input('search');

        // Khởi tạo query với eager loading 'department'
        $employees = Employee::with('department')
            // Nếu có từ khóa tìm kiếm, thêm điều kiện where
            ->when($search, function ($query) use ($search) {
                return $query->where('name', 'LIKE', "%{$search}%")
                    ->orWhere('email', 'LIKE', "%{$search}%");
            })
            // ->orderByDesc('id')
            ->paginate(10); // 

        return view('employees.index', compact('employees'));
    }
    /**
     * Hiển thị form thêm mới nhân viên.
     */
    public function create()
    {
        // Lấy danh sách phòng ban để hiển thị trong thẻ <select>
        $departments = Department::all();

        return view('employees.create', compact('departments'));
    }

    /**
     * Lưu nhân viên mới vào cơ sở dữ liệu.
     */
    public function store(Request $request)
    {
        // Kiểm tra tính hợp lệ của dữ liệu theo yêu cầu đề bài
        $request->validate([
            'department_id' => 'required|exists:departments,id',
            'name'          => 'required|max:100',
            'email'         => 'required|email|unique:employees,email|max:100',
            'phone'         => 'nullable|max:20',
            'position'      => 'required|in:VP,Manager,Staff',
            'salary'        => 'required|numeric|min:0',
        ], [
            // Tùy chỉnh thông báo lỗi tiếng Việt (tùy chọn)
            'email.email'   => 'Địa chỉ email không đúng định dạng (phải có ký tự @).',
            'email.unique' => 'Email này đã tồn tại trong hệ thống.',
            'position.in'  => 'Chức vụ phải là VP, Manager hoặc Staff.'
        ]);

        // Lưu dữ liệu vào bảng employees
        Employee::create($request->all());

        // Chuyển hướng về trang danh sách với thông báo thành công
        return redirect()->route('employees.index')->with('success', 'Thêm nhân viên thành công!');
    }

    /**
     * Hiển thị chi tiết một nhân viên (nếu cần).
     */
    public function show(string $id)
    {
        // Lấy thông tin nhân viên cùng phòng ban liên kết 
        $employee = Employee::with('department')->findOrFail($id);
        return view('employees.show', compact('employee'));
    }

    /**
     * Hiển thị form chỉnh sửa thông tin nhân viên.
     */
    public function edit($id)
    {
        $employee = Employee::findOrFail($id);
        $departments = Department::all();

        return view('employees.edit', compact('employee', 'departments'));
    }

    /**
     * Cập nhật thông tin nhân viên vào cơ sở dữ liệu.
     */
    public function update(Request $request, $id)
    {
        $employee = Employee::findOrFail($id);

        $request->validate([
            'department_id' => 'required|exists:departments,id',
            'name'          => 'required|max:100',
            // Email duy nhất nhưng ngoại trừ ID hiện tại của nhân viên đang sửa
            'email'         => 'required|email|max:100|unique:employees,email,' . $id,
            'phone'         => 'nullable|max:20',
            'position'      => 'required|in:VP,Manager,Staff',
            'salary'        => 'required|numeric|min:0',
        ]);

        $employee->update($request->all());

        return redirect()->route('employees.index')->with('success', 'Cập nhật thông tin nhân viên thành công!');
    }

    /**
     * Xóa nhân viên khỏi cơ sở dữ liệu.
     */
    public function destroy($id)
    {
        $employee = Employee::findOrFail($id);
        $employee->delete();

        return redirect()->route('employees.index')->with('success', 'Xóa nhân viên thành công!');
    }
}
