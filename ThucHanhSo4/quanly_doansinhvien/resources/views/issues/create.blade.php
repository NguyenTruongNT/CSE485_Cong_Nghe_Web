@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Thêm vấn đề báo cáo mới</div>
                    <div class="card-body">
                        <form action="{{ route('issues.store') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="computer_id" class="form-label">Máy tính</label>
                                <select name="computer_id" class="form-select" required>
                                    <option value="">-- Chọn máy tính --</option>
                                    @foreach($computers as $computer)
                                        <option value="{{ $computer->id }}">{{ $computer->computer_name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="reported_by" class="form-label">Người báo cáo</label>
                                <input type="text" name="reported_by" class="form-control" id="reported_by" maxlength="50">
                            </div>

                            <div class="mb-3">
                                <label for="reported_date" class="form-label">Thời gian báo cáo</label>
                                <input type="datetime-local" name="reported_date" class="form-control" id="reported_date"
                                    required>
                            </div>

                            <div class="mb-3">
                                <label for="urgency" class="form-label">Mức độ sự cố</label>
                                <select name="urgency" class="form-select" id="urgency" required>
                                    <option value="Low">Low</option>
                                    <option value="Medium">Medium</option>
                                    <option value="High">High</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="status" class="form-label">Trạng thái hiện tại</label>
                                <select name="status" class="form-select" id="status" required>
                                    <option value="Open">Open</option>
                                    <option value="In Progress">In Progress</option>
                                    <option value="Resolved">Resolved</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="description" class="form-label">Mô tả chi tiết vấn đề</label>
                                <textarea name="description" class="form-control" id="description" rows="3"
                                    required></textarea>
                            </div>

                            <button type="submit" class="btn btn-primary">Thêm mới</button>
                            <a href="{{ route('issues.index') }}" class="btn btn-secondary">Quay lại</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection