<?php

namespace App\Http\Controllers;

use App\Helpers\LocationHelper;
use App\Models\Attendance;
use App\Models\Setting;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('attendance_user_system/login');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    $officeLat = Setting::getValue('office_latitude');
    $officeLon = Setting::getValue('office_longitude');

    \Log::info('Attendance request received', $request->all()); // Log request

    $request->validate([
        'user_id' => 'required|string',
        'latitude' => 'required|numeric',
        'longitude' => 'required|numeric',
    ]);

    // $officeLat = env('OFFICE_LATITUDE', 5.9998208);
    // $officeLon = env('OFFICE_LONGITUDE', 80.2619392);
    // $officeLat = env('OFFICE_LATITUDE', 6.6357887);
    // $officeLon = env('OFFICE_LONGITUDE', 80.7119126);
    $radius = env('RADIUS_METERS', 100);

    $distance = LocationHelper::getDistance(
        $request->latitude,
        $request->longitude,
        $officeLat,
        $officeLon
    );

    \Log::info('Comparing locations', [
        'office_lat' => $officeLat,
        'office_lon' => $officeLon,
        'request_lat' => $request->latitude,
        'request_lon' => $request->longitude,
    ]);

    \Log::info('Calculated Distance', ['distance' => $distance]);

    if ($distance > $radius) {
        \Log::info('Employee outside allowed area', ['distance' => $distance]);
        
        return response()->json([
            'error' => true,
            'message' => 'You are outside the allowed attendance area.',
            'distance' => $distance,
        ], 403);
    }

     // Prevent duplicate entries within 12 hours
     $recentAttendance = Attendance::where('user_id', $request->user_id)
     ->where('created_at', '>=', now()->subHours(12))
     ->exists();

    if ($recentAttendance) {
        \Log::info('Attendance entry blocked - Duplicate within 12 hours', ['user_id' => $request->user_id]);

        return response()->json([
            'error' => true,
            'message' => 'Attendance already recorded within the past 12 hours.',
        ], 403);
    }

    $attendance = Attendance::create([
        'user_id' => $request->user_id,
        'latitude' => $request->latitude,
        'longitude' => $request->longitude,
    ]);

    \Log::info('Attendance recorded successfully', $attendance->toArray());

    return response()->json([
        'message' => 'Attendance recorded!',
        'data' => $attendance,
        'distance' => $distance,
    ], 201);
}

    /**
     * Display the specified resource.
     */
    public function show(attendance $attendance)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(attendance $attendance)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, attendance $attendance)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(attendance $attendance)
    {
        //
    }
}
