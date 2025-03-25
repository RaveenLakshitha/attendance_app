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
                                        <th>Location</th>
                                        <th>Photo</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($attendances as $attendance)
                                        <tr>
                                            <td>{{ $attendance->user_name }}</td>
                                            <td>{{ \Carbon\Carbon::parse($attendance->checked_in_at)->format('h:i A') }}</td>
                                            <td>{{ \Carbon\Carbon::parse($attendance->checked_in_at)->format('M d, Y') }}</td>
                                            <td>
                                                @if($attendance->latitude && $attendance->longitude)
                                                    <a href="https://www.google.com/maps?q={{ $attendance->latitude }},{{ $attendance->longitude }}" 
                                                       target="_blank" 
                                                       class="btn btn-sm btn-outline-primary">
                                                        <i class="fas fa-map-marker-alt"></i> View Map
                                                    </a>
                                                @else
                                                    <span class="text-muted">No location</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($attendance->photo_path)
                                                    <button type="button" 
                                                            class="btn btn-sm btn-outline-secondary" 
                                                            data-bs-toggle="modal" 
                                                            data-bs-target="#photoModal{{ $attendance->id }}">
                                                        <i class="fas fa-camera"></i> View Photo
                                                    </button>
                                                    
                                                    <!-- Modal for photo -->
                                                    <div class="modal fade" id="photoModal{{ $attendance->id }}" tabindex="-1" aria-hidden="true">
                                                        <div class="modal-dialog modal-lg">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title">
                                                                        {{ $attendance->user_name }} - {{ \Carbon\Carbon::parse($attendance->checked_in_at)->format('M d, Y h:i A') }}
                                                                    </h5>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body text-center">
                                                                    <img src="{{ asset('storage/' . $attendance->photo_path) }}" 
                                                                         class="img-fluid" 
                                                                         alt="Attendance photo"
                                                                         style="max-height: 70vh;">
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @else
                                                    <span class="text-muted">No photo</span>
                                                @endif
                                            </td>
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
@endsection