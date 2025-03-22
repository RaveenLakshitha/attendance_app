<?php

namespace App\Services;

use App\Repository\AttendanceRepository;

class AttndanceService
{
    protected $attendanceRepository;
    protected $authService;

    /**
     * Create a new class instance.
     */
    public function __construct(AttendanceRepository $attendanceRepository, AuthService $authService)
    {
        $this->attendanceRepository = $attendanceRepository;
        $this->authService    = $authService;
    }

    /**
     * Function: getAttendances
     * Description: To fetch attendances based on logged in user
     */
    public function getAttendances()
    {
        # Get Auth User
        $authUser = $this->authService->getAuthUser();

        # Fetch Attendances based on Auth User id
        return $this->attendanceRepository->getAttendances($authUser->id);
    }

    /**
     * Function: storeAttendance
     * @param array $attendanceRequest
     */
    public function storeAttendance($attendanceRequest)
    {
        # Prepare Attendance Request
        $attendanceRequest = $this->prepareAttendanceRequest($attendanceRequest);

        return $this->attendanceRepository->storeAttendance($attendanceRequest);
    }

    /**
     * Function: prepareAttendanceRequest
     * @param object $attendanceRequest
     * @return array $attendanceRequest
     */
    public function prepareAttendanceRequest($attendanceRequest)
    {
        # Get Auth User
        $authUser = $this->authService->getAuthUser();

        $attendanceRequest            = $attendanceRequest->all();
        $attendanceRequest['user_id'] = $authUser->id;

        return $attendanceRequest;
    }

    /**
     * Function: showAttendance
     * @param Attendance $attendance
     */
    public function showAttendance($attendance)
    {
        # Get Auth User
        $authUser = $this->authService->getAuthUser();

        return $this->attendanceRepository->getAttendance($attendance, $authUser->id);
    }

    /**
     * Function: updateAttendance
     * @param object $attendanceRequest
     * @param Attendance $attendance
     * @return $attendance
     */
    public function updateAttendance($attendanceRequest, $attendance)
    {

        # Find Attendance Based on Attendance Id and Auth User Id
        $attendance = $this->showAttendance($attendance);

        if ($attendance) {
            $attendance->title       = $attendanceRequest->title;
            $attendance->description = $attendanceRequest->description;

            return $attendance->save();
        }
    }

    /**
     * Function: deleteAttendance
     * @param Attendance $attendance
     */
    public function deleteAttendance($attendance)
    {
        # Find Attendance Based on Attendance Id and Auth User Id
        $attendance = $this->showAttendance($attendance);

        if ($attendance) {
            return $attendance->delete();
        }
    }
}
