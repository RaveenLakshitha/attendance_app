@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-white">
                    <h2 class="card-title mb-0">Update Office Location</h2>
                </div>

                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('update.office.location') }}">
                        @csrf
                        <div class="mb-3">
                            <label for="latitude" class="form-label">Office Latitude:</label>
                            <input type="text" id="latitude" name="latitude" class="form-control" required value="{{ $officeLat }}">
                        </div>

                        <div class="mb-3">
                            <label for="longitude" class="form-label">Office Longitude:</label>
                            <input type="text" id="longitude" name="longitude" class="form-control" required value="{{ $officeLon }}">
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save"></i> Save Location
                            </button>
                            <button type="button" class="btn btn-secondary" onclick="history.back()">
                                <i class="bi bi-arrow-left"></i> Back
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection