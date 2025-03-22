<?php
namespace App\Repository;

use App\Models\Attendance;


class AttendanceRepository
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Function: getattendances
     * @param int $userId
     */
    public function getattendances($userId)
    {
        return Attendance::where('user_id', $userId)->paginate(10);
    }

    /**
     * Function: storeattendance
     * @param array $attendanceRequest
     * @return object attendance
     */
    public function storeattendance($attendanceRequest)
    {
        return Attendance::create($attendanceRequest);
    }

    /**
     * Function: getattendance
     * @param Attendance $attendance
     */
    public function getattendance($attendance, $userId)
    {
        return $attendance->where('user_id', $userId)->first();
    }
}