@extends('layouts.app')

@section('content')
<div id="app">
    <div class="container-fluid mt-4">
        <div class="row">
            <!-- Main Content -->
            <div class="col-md-12">
                <div class="card shadow-sm">
                    <div class="card-header bg-white">
                        <h5 class="card-title mb-0">User Details</h5>
                    </div>
                    <div class="card-body">
                        @if(session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Profile</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Device ID</th>
                                        <th>Action</th>
                                        <th>Image Upload</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($users as $user)
                                        <tr>
                                            <td>
                                                @if($user->profile_picture)
                                                <img src="{{ Storage::url($user->profile_picture) }}"
                                                         alt="Profile Picture" 
                                                         class="rounded-circle" 
                                                         width="50" 
                                                         height="50">
                                                @else
                                                    <div class="bg-secondary rounded-circle d-flex align-items-center justify-content-center" 
                                                         style="width: 50px; height: 50px;">
                                                        <span class="text-white">{{ substr($user->name, 0, 1) }}</span>
                                                    </div>
                                                @endif
                                            </td>
                                            <td>{{ $user->name }}</td>
                                            <td>{{ $user->email }}</td>
                                            <td>{{ $user->device_id ?? 'N/A' }}</td>
                                            <td>
                                                <div class="d-flex gap-2">
                                                    @if($user->device_id)
                                                        <form action="{{ route('users.clearDeviceId', $user->id) }}" method="POST" class="d-inline">
                                                            @csrf
                                                            @method('POST')
                                                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                                                <i class="bi bi-trash"></i> Clear Device ID
                                                            </button>
                                                        </form>
                                                    @else
                                                        <span class="text-muted">No Device ID</span>
                                                    @endif
                                                </td>  
                                                <td>  
                                                    <!-- Profile Picture Upload Form -->
                                                    <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#uploadModal{{ $user->id }}">
                                                        <i class="bi bi-upload"></i> Upload Photo
                                                    </button>
                                                </div>
                                                
                                                <!-- Upload Modal -->
                                                <div class="modal fade" id="uploadModal{{ $user->id }}" tabindex="-1" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Upload Profile Picture</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <form action="{{ route('users.uploadProfilePicture', $user->id) }}" method="POST" enctype="multipart/form-data">
                                                                @csrf
                                                                <div class="modal-body">
                                                                    <div class="mb-3">
                                                                        <label for="profile_picture" class="form-label">Select Image</label>
                                                                        <input class="form-control" type="file" id="profile_picture" name="profile_picture" accept="image/*" required>
                                                                        <div class="form-text">Max file size: 2MB. Allowed formats: jpg, png, gif.</div>
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                                    <button type="submit" class="btn btn-primary">Upload</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
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