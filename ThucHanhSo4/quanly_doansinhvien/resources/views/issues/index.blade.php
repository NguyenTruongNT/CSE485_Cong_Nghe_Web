@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">Danh sách vấn đề báo cáo</h4>
                        <a href="{{ route('issues.create') }}" class="btn btn-primary">Thêm vấn đề mới</a>
                    </div>
                    <div class="card-body">
                        @if(session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>Mã vấn đề</th>
                                    <th>Tên máy tính</th>
                                    <th>Tên phiên bản</th>
                                    <th>Người báo cáo</th>
                                    <th>Thời gian báo cáo</th>
                                    <th>Mức độ</th>
                                    <th>Trạng thái hiện tại</th>
                                    <th>Hành động</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($issues as $issue)
                                    <tr>
                                        <td>{{ $issue->id }}</td>
                                        <td>{{ $issue->computer->computer_name }}</td>
                                        <td>{{ $issue->computer->model }}</td>
                                        <td>{{ $issue->reported_by }}</td>
                                        <td>{{ $issue->reported_date }}</td>
                                        <td>
                                            <span
                                                class="badge @if($issue->urgency == 'High') bg-danger @elseif($issue->urgency == 'Medium') bg-warning @else bg-info @endif">
                                                {{ $issue->urgency }}
                                            </span>
                                        </td>
                                        <td>
                                            <span
                                                class="badge @if($issue->status == 'Open') bg-secondary @elseif($issue->status == 'In Progress') bg-primary @else bg-success @endif">
                                                {{ $issue->status }}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('issues.edit', $issue->id) }}"
                                                    class="btn btn-sm btn-warning">Sửa</a>

                                                <form action="{{ route('issues.destroy', $issue->id) }}" method="POST"
                                                    onsubmit="return confirm('Bạn có chắc chắn muốn xóa vấn đề này không?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger ms-1">Xóa</button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <div class="d-flex justify-content-center mt-3">
                            {{ $issues->links('pagination::bootstrap-5') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection