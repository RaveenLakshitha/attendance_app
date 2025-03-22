@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h2>Update Office Location</h2></div>

                <div class="card-body">
                    @if(session('success'))
                        <p style="color: green;">{{ session('success') }}</p>
                    @endif

                    <form method="POST" action="{{ route('update.office.location') }}">
                        @csrf
                        <label for="latitude">Office Latitude:</label>
                        <input type="text" id="latitude" name="latitude" required value="{{ $officeLat }}">
                        
                        <label for="longitude">Office Longitude:</label>
                        <input type="text" id="longitude" name="longitude" required value="{{ $officeLon }}">
                        
                        <button type="submit">Save Location</button>
                        <button type="button" onclick="history.back()">Back</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

