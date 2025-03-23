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
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Device ID</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($users as $user)
                                        <tr>
                                            <td>{{ $user->name }}</td>
                                            <td>{{ $user->email }}</td>
                                            <td>{{ $user->device_id ?? 'N/A' }}</td>
                                            <td>
                                                @if($user->device_id)
                                                    <form action="{{ route('users.clearDeviceId', $user->id) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        @method('POST')
                                                        <button type="submit" class="btn-clear">
                                                            <i class="bi bi-trash"></i> Clear Device ID
                                                        </button>
                                                    </form>
                                                @else
                                                    <span class="text-muted">No Device ID</span>
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

