@extends('layouts.app')

@section('content')
<div id="app">

    <div class="container-fluid mt-4">
        <div class="row">
            <!-- Main Content -->
            <div class="col-md-12">
                <div class="card shadow-sm">
                    <div class="card-header bg-white">
                        <h5 class="card-title mb-0">Attendance Records</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>User Name</th>
                                        <th>Checked-In Time</th>
                                        <th>Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($attendances as $attendance)
                                        <tr>
                                            <td>{{ $attendance->user_name }}</td>
                                            <td>{{ \Carbon\Carbon::parse($attendance->checked_in_at)->format('h:i A') }}</td>
                                            <td>{{ \Carbon\Carbon::parse($attendance->checked_in_at)->format('M d, Y') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
@endsection

