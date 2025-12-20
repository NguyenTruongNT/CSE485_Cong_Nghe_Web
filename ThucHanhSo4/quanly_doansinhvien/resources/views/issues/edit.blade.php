@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Cập nhật thông tin vấn đề</div>
                    <div class="card-body">
                        <form action="{{ route('issues.update', $issue->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label for="computer_id" class="form-label">Máy tính</label>
                                <select name="computer_id" id="computer_id" class="form-select" required>
                                    @foreach($computers as $computer)
                                        <option value="{{ $computer->id }}" {{ $issue->computer_id == $computer->id ? 'selected' : '' }}>
                                            {{ $computer->computer_name }} ({{ $computer->model }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="reported_by" class="form-label">Người báo cáo</label>
                                <input type="text" name="reported_by" class="form-control" id="reported_by"
                                    value="{{ $issue->reported_by }}" maxlength="50">
                            </div>

                            <div class="mb-3">
                                <label for="reported_date" class="form-label">Thời gian báo cáo</label>
                                <input type="datetime-local" name="reported_date" class="form-control" id="reported_date"
                                    value="{{ date('Y-m-d\TH:i', strtotime($issue->reported_date)) }}" required>
                            </div>

                            <div class="mb-3">
                                <label for="urgency" class="form-label">Mức độ sự cố</label>
                                <select name="urgency" class="form-select" id="urgency" required>
                                    <option value="Low" {{ $issue->urgency == 'Low' ? 'selected' : '' }}>Low</option>
                                    <option value="Medium" {{ $issue->urgency == 'Medium' ? 'selected' : '' }}>Medium</option>
                                    <option value="High" {{ $issue->urgency == 'High' ? 'selected' : '' }}>High</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="status" class="form-label">Trạng thái hiện tại</label>
                                <select name="status" class="form-select" id="status" required>
                                    <option value="Open" {{ $issue->status == 'Open' ? 'selected' : '' }}>Open</option>
                                    <option value="In Progress" {{ $issue->status == 'In Progress' ? 'selected' : '' }}>In
                                        Progress</option>
                                    <option value="Resolved" {{ $issue->status == 'Resolved' ? 'selected' : '' }}>Resolved
                                    </option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="description" class="form-label">Mô tả chi tiết vấn đề</label>
                                <textarea name="description" class="form-control" id="description" rows="3"
                                    required>{{ $issue->description }}</textarea>
                            </div>

                            <button type="submit" class="btn btn-primary">Cập nhật</button>
                            <a href="{{ route('issues.index') }}" class="btn btn-secondary">Quay lại</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection