<?php

namespace App\Http\Controllers;

use App\Helpers\LocationHelper;
use App\Models\Attendance;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class AttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $attendances = Attendance::join('users', 'attendances.user_id', '=', 'users.id')
            ->select('attendances.*', 'users.name as user_name')
            ->orderBy('checked_in_at', 'desc')
            ->get();

        return view('attendanceDetails', compact('attendances'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $officeLat = Setting::getValue('office_latitude');
        $officeLon = Setting::getValue('office_longitude');
        $radius = env('RADIUS_METERS', 100);

        Log::info('Attendance request received', $request->all());

        // Validate request data
        $request->validate([
            'user_id' => 'required|string',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'checked_in_at' => 'required|date',
            'photo' => 'required|image|max:15048', // Max 2MB
        ]);

        // Calculate distance from office
        $distance = LocationHelper::getDistance(
            $request->latitude,
            $request->longitude,
            $officeLat,
            $officeLon
        );

        Log::info('Location comparison', [
            'office_lat' => $officeLat,
            'office_lon' => $officeLon,
            'request_lat' => $request->latitude,
            'request_lon' => $request->longitude,
            'distance' => $distance
        ]);

        // Check if within allowed radius
        if ($distance > $radius) {
            Log::info('Employee outside allowed area', ['distance' => $distance]);
            
            return response()->json([
                'error' => true,
                'message' => 'You are outside the allowed attendance area.',
                'distance' => $distance,
            ], 403);
        }

        // Prevent duplicate entries within 12 hours
        $recentAttendance = Attendance::where('user_id', $request->user_id)
            ->where('checked_in_at', '>=', now()->subHours(12))
            ->exists();

        if ($recentAttendance) {
            Log::info('Duplicate attendance attempt', ['user_id' => $request->user_id]);
            return response()->json([
                'error' => true,
                'message' => 'Already recorded within the past 12 hours.',
            ], 403);
        }

        // Handle file upload
        try {
            $photoPath = $request->file('photo')->store('attendance_photos', 'public');
            
            // Create attendance record
            $attendance = Attendance::create([
                'user_id' => $request->user_id,
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
                'checked_in_at' => $request->checked_in_at,
                'photo_path' => $photoPath,
            ]);

            Log::info('Attendance recorded successfully', $attendance->toArray());

            return response()->json([
                'message' => 'Attendance recorded successfully!',
                'data' => $attendance,
                'distance' => $distance,
                'photo_url' => Storage::url($photoPath),
            ], 201);

        } catch (\Exception $e) {
            Log::error('Attendance recording failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'error' => true,
                'message' => 'Failed to record attendance. Please try again.',
                'details' => $e->getMessage()
            ], 500);
        }
    }

    // ... (keep other methods unchanged)
}