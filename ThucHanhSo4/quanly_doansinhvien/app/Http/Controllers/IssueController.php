<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Issue;

class IssueController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Lấy dữ liệu sự cố kèm thông tin máy tính, phân 10 bản ghi mỗi trang
        // Sử dụng latest() để tự động sắp xếp theo created_at giảm dần ->latest('id')
        // Hoặc orderByDesc('id') để sắp xếp theo ID giảm dần
        $issues = Issue::with('computer')->paginate(10);
        return view('issues.index', compact('issues'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Lấy toàn bộ danh sách máy tính để hiển thị trong thẻ <select> 
        $computers = \App\Models\Computer::all();

        // Đảm bảo file view nằm đúng tại: resources/views/issues/create.blade.php
        return view('issues.create', compact('computers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Kiểm tra tính hợp lệ của dữ liệu trước khi lưu
        $request->validate([
            'computer_id' => 'required|exists:computers,id',
            'reported_by' => 'nullable|max:50',
            'reported_date' => 'required|date',
            'description' => 'required',
            'urgency' => 'required|in:Low,Medium,High',
            'status' => 'required|in:Open,In Progress,Resolved',
        ]);

        // Lưu dữ liệu vào bảng issues
        \App\Models\Issue::create($request->all());

        // Chuyển hướng về trang danh sách với thông báo thành công
        return redirect()->route('issues.index')->with('success', 'Vấn đề đã được thêm thành công!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $issue = Issue::findOrFail($id);
        $computers = \App\Models\Computer::all();
        return view('issues.edit', compact('issue', 'computers'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'computer_id' => 'required',
            'reported_date' => 'required',
            'description' => 'required',
            'urgency' => 'required',
            'status' => 'required',
        ]);

        $issue = Issue::findOrFail($id);
        $issue->update($request->all());

        return redirect()->route('issues.index')->with('success', 'Vấn đề đã được cập nhật thành công!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $issue = Issue::findOrFail($id);
        $issue->delete();

        return redirect()->route('issues.index')->with('success', 'Vấn đề đã được xóa thành công!');
    }
}
