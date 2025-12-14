<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /** * Display a listing of the resource. 
     */
    public function index()
    {
        $tasks = Task::all();
        return view('tasks.index', compact('tasks'));
    }

    /** * Show the form for creating a new resource. 
     */
    public function create()
    {
        return view('tasks.create');
    }

    /** * Store a newly created resource in storage. 
     * Cập nhật: Xử lý giá trị của Checkbox 'completed'
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required',
            'description' => 'required',
            // long_description và completed không cần required vì chúng có thể null/false
            'long_description' => 'nullable|string',
        ]);

        // Xử lý giá trị 'completed' thủ công để tránh lỗi 'on'
        $validatedData['completed'] = $request->has('completed');

        // Thêm các trường khác (long_description) vào $validatedData
        if ($request->has('long_description')) {
            $validatedData['long_description'] = $request->input('long_description');
        }

        // Tạo task với dữ liệu đã được xử lý
        Task::create($validatedData);

        return redirect()->route('tasks.index')->with('success', 'Task created successfully.');
    }

    /** * Display the specified resource. 
     */
    public function show(Task $task)
    {
        return view('tasks.show', compact('task'));
    }

    /** * Show the form for editing the specified resource. 
     */
    public function edit(Task $task)
    {
        return view('tasks.edit', compact('task'));
    }

    /** * Update the specified resource in storage. 
     * Cập nhật: Xử lý giá trị của Checkbox 'completed'
     */
    public function update(Request $request, Task $task)
    {
        $validatedData = $request->validate([
            'title' => 'required',
            'description' => 'required',
            'long_description' => 'nullable|string',
        ]);

        // Xử lý giá trị 'completed' thủ công để tránh lỗi 'on'
        $validatedData['completed'] = $request->has('completed');

        // Thêm các trường khác (long_description) vào $validatedData
        if ($request->has('long_description')) {
            $validatedData['long_description'] = $request->input('long_description');
        } else {
            // Đảm bảo trường long_description được cập nhật thành NULL nếu form gửi lên không có
            $validatedData['long_description'] = null;
        }

        // Cập nhật task với dữ liệu đã được xử lý
        $task->update($validatedData);

        return redirect()->route('tasks.index')->with('success', 'Task updated successfully.');
    }

    /** * Remove the specified resource from storage. 
     */
    public function destroy(Task $task)
    {
        $task->delete();

        return redirect()->route('tasks.index')->with('success', 'Task deleted successfully.');
    }
}
