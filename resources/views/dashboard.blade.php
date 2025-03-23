<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #e3f2fd;
            margin: 0;
        }
        .container {
            background: #ffffff;
            padding: 30px 40px;
            border-radius: 20px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 420px;
            text-align: center;
        }
        h3 {
            color: #1565c0;
            margin-bottom: 20px;
        }
        .section {
            background: #f1f8fe;
            padding: 20px;
            border-radius: 12px;
            margin-bottom: 20px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }
        button {
            width: 100%;
            background-color: #1565c0;
            color: #fff;
            border: none;
            padding: 12px 20px;
            border-radius: 8px;
            cursor: pointer;
            font-weight: bold;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }
        button:hover {
            background-color: #0d47a1;
        }
        .icon-btn {
            font-size: 18px;
        }
        .status-message {
            margin: 25px 0;
            font-weight: bold;
        }
        #profile-section p {
            margin: 15px 0;
        }
        #user-name-header {
            text-transform: uppercase;
        }
    </style>
</head>
<body>
    <div class="container">
        <h3><i class="fas fa-user-circle"></i> Welcome <span id="user-name-header"></span></h3>

        <!-- Attendance Section -->
        <div class="section">
            <h4><i class="fas fa-calendar-check icon-btn"></i> Attendance</h4>
            <input type="hidden" id="employee-id" name="employee-id">
            <input type="hidden" id="latitude" name="latitude">
            <input type="hidden" id="longitude" name="longitude">
            <div id="statusMessage" class="status-message alert alert-info d-flex align-items-center">
                <i class="fas fa-info-circle me-2"></i>
                <span>Waiting for location...</span>
            </div>
            <button onclick="markAttendance()">
                <i class="fas fa-check-circle icon-btn"></i> Mark Attendance
            </button>
        </div>

        <!-- Profile Section -->
        <div class="section">
            <h4><i class="fas fa-id-card"></i> Profile</h4>
            <div id="profile-section">
                <p><strong>Name:</strong> <span id="user-name">Loading...</span></p>
                <p><strong>Email:</strong> <span id="user-email">Loading...</span></p>
            </div>
            <button onclick="logout()">
                <i class="fas fa-sign-out-alt icon-btn"></i> Logout
            </button>
        </div>
    </div>

    <!-- jQuery -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function () {
            getProfileData();
        });

        function getProfileData() {
            let token = localStorage.getItem('authToken');
            if (!token) {
                alert('User not authenticated. Redirecting to login.');
                window.location.href = 'http://localhost/test/Attendance_Sample/AttendanceApplication/public/loginUI';
                return;
            }

            $.ajax({
                url: 'http://localhost/test/Attendance_Sample/AttendanceApplication/public/api/auth/profile',
                type: 'GET',
                headers: { 'Authorization': 'Bearer ' + token },
                success: function(response) {
                    console.log(response);
                    $('#user-name-header').text(response.data.name || 'N/A');
                    $('#user-name').text(response.data.name || 'N/A');
                    $('#user-email').text(response.data.email || 'N/A');
                    $('#employee-id').val(response.data.id);
                },
                error: function() {
                    alert('Failed to fetch profile data. Please login again.');
                    localStorage.removeItem('authToken');
                    window.location.href = 'http://localhost/test/Attendance_Sample/AttendanceApplication/public/loginUI';
                }
            });
        }

        function logout() {
            localStorage.removeItem('authToken');
            window.location.href = 'http://localhost/test/Attendance_Sample/AttendanceApplication/public/loginUI';
        }

        async function getLocation() {
            $('#statusMessage').html(`
                <div class="alert alert-warning d-flex align-items-center">
                    <i class="fas fa-spinner fa-spin me-2"></i>
                    <span>Getting location...</span>
                </div>
            `);

            if (!navigator.geolocation) {
                $('#statusMessage').html(`
                    <div class="alert alert-danger d-flex align-items-center">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <span>Geolocation is not supported by your browser.</span>
                    </div>
                `);
                return null;
            }

            return new Promise((resolve, reject) => {
                navigator.geolocation.getCurrentPosition(
                    (position) => {
                        const latitude = position.coords.latitude;
                        const longitude = position.coords.longitude;

                        $('#latitude').val(latitude);
                        $('#longitude').val(longitude);
                        $('#statusMessage').html(`
                            <div class="alert alert-success d-flex align-items-center">
                                <i class="fas fa-check-circle me-2"></i>
                                <span>Location detected: ${latitude}, ${longitude}</span>
                            </div>
                        `);

                        resolve({ latitude, longitude });
                    },
                    (error) => {
                        $('#statusMessage').html(`
                            <div class="alert alert-danger d-flex align-items-center">
                                <i class="fas fa-exclamation-triangle me-2"></i>
                                <span>Error: ${error.message}</span>
                            </div>
                        `);
                        reject(error);
                    },
                    { enableHighAccuracy: true, timeout: 100000 }
                );
            });
        }

        async function markAttendance() {
            try {
                let employeeId = $('#employee-id').val();

                // Get the location and wait for it
                const location = await getLocation();
                if (!location) return;

                let postData = {
                    user_id: employeeId,
                    latitude: location.latitude,
                    longitude: location.longitude
                };

                let token = localStorage.getItem('authToken');
                if (!token) {
                    alert('User not authenticated. Redirecting to login.');
                    window.location.href = 'http://localhost/test/Attendance_Sample/AttendanceApplication/public/loginUI';
                    return;
                }

                let response = await fetch("http://localhost/test/Attendance_Sample/AttendanceApplication/public/api/attendance", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "Accept": "application/json",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}",
                        'Authorization': 'Bearer ' + token
                    },
                    body: JSON.stringify(postData),
                });

                let responseData = await response.json();

                if (response.ok) {
                    $('#statusMessage').html(`
                        <div class="alert alert-success d-flex align-items-center">
                            <i class="fas fa-check-circle me-2"></i>
                            <span>${responseData.message}</span>
                        </div>
                    `);
                } else {
                    $('#statusMessage').html(`
                        <div class="alert alert-danger d-flex align-items-center">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            <span>${responseData.message}</span>
                        </div>
                    `);
                }
            } catch (error) {
                console.error("Error submitting attendance:", error);
                $('#statusMessage').html(`
                    <div class="alert alert-danger d-flex align-items-center">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <span>Error submitting attendance. Try again.</span>
                    </div>
                `);
            }
        }

        // Auto-fetch location when the page loads
        document.addEventListener("DOMContentLoaded", getLocation);
    </script>
</body>
</html>