<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&family=Orbitron:wght@400;500&display=swap" rel="stylesheet">
    <!-- Custom CSS -->
    <style>
        :root {
            --primary-color: #4361ee;
            --primary-hover: #3a56d4;
            --secondary-color: #3f37c9;
            --accent-color: #4cc9f0;
            --light-bg: #f8f9fa;
            --card-shadow: 0 10px 30px -15px rgba(0, 0, 0, 0.1);
            --success-color: #28a745;
            --error-color: #dc3545;
            --warning-color: #ffc107;
            --info-color: #17a2b8;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background: linear-gradient(135deg, #f5f7fa 0%, #e4f1fe 100%);
            margin: 0;
        }
        
        .container {
            background: #ffffff;
            padding: 40px;
            border-radius: 20px;
            box-shadow: var(--card-shadow);
            border: 1px solid rgba(255, 255, 255, 0.2);
            width: 100%;
            max-width: 480px;
            text-align: center;
            position: relative;
        }
        
        h3 {
            color: var(--primary-color);
            margin-bottom: 25px;
            font-weight: 600;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }
        
        .section {
            background: var(--light-bg);
            padding: 25px;
            border-radius: 16px;
            margin-bottom: 25px;
            box-shadow: var(--card-shadow);
            transition: transform 0.3s ease;
        }
        
        .section:hover {
            transform: translateY(-3px);
        }
        
        h4 {
            color: var(--primary-color);
            font-weight: 500;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }
        
        button {
            width: 100%;
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            color: #fff;
            border: none;
            padding: 14px 20px;
            border-radius: 12px;
            cursor: pointer;
            font-weight: 500;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(67, 97, 238, 0.2);
        }
        
        button:hover {
            background: linear-gradient(135deg, var(--primary-hover) 0%, #3a56d4 100%);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(67, 97, 238, 0.3);
        }
        
        .btn-logout {
            background: transparent;
            color: var(--primary-color);
            border: 2px solid var(--primary-color);
            box-shadow: none;
        }
        
        .btn-logout:hover {
            background: rgba(67, 97, 238, 0.1);
            transform: translateY(-2px);
        }
        
        .status-container {
            position: relative;
            margin: 25px 0;
            min-height: 80px;
        }
        
        .status-message {
            position: absolute;
            width: 100%;
            top: 0;
            left: 0;
            font-weight: 500;
            border-radius: 12px;
            padding: 15px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transform: translateY(10px);
            transition: all 0.4s ease;
            z-index: 1;
        }
        
        .status-message.active {
            opacity: 1;
            transform: translateY(0);
            z-index: 2;
        }
        
        .status-icon {
            font-size: 1.5rem;
            margin-bottom: 8px;
        }
        
        .status-text {
            text-align: center;
            margin-bottom: 5px;
        }
        
        .status-details {
            font-size: 0.85rem;
            color: rgba(255, 255, 255, 0.8);
            word-break: break-all;
        }
        
        .alert-success {
            background: var(--success-color);
            color: white;
        }
        
        .alert-error {
            background: var(--error-color);
            color: white;
        }
        
        .alert-warning {
            background: var(--warning-color);
            color: #212529;
        }
        
        .alert-info {
            background: var(--info-color);
            color: white;
        }
        
        #profile-section p {
            margin: 15px 0;
            text-align: left;
            padding: 10px 15px;
            background: rgba(255, 255, 255, 0.8);
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
        }
        
        #profile-section strong {
            color: var(--primary-color);
            margin-right: 8px;
        }
        
        #user-name-header {
            text-transform: capitalize;
        }
        .date-display {
            font-size: 1.2rem;
            margin-bottom: 5px;
            color: #555;
        }

        .digital-clock {
            font-family: 'Orbitron', sans-serif;
            font-size: 2.5rem;
            font-weight: 500;
            color: var(--primary-color);
            margin: 20px 0;
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 5px;
        }
        
        .clock-colon {
            animation: blink 1s infinite;
        }
        
        @keyframes blink {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.5; }
        }
        
        .spinner {
            animation: spin 1s linear infinite;
        }
        
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        .check-in-btn {
            /* Circular shape */
            width: 150px;
            height: 150px;
            border-radius: 50%;
            
            /* Keep your existing styles */
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            color: #fff;
            border: none;
            cursor: pointer;
            font-weight: 500;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 5px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(67, 97, 238, 0.2);
            
            /* Positioning for mobile */
            margin: 50px auto 10px auto;
            padding: 10px;
        }

.check-in-btn:hover {
    background: linear-gradient(135deg, var(--primary-hover) 0%, #3a56d4 100%);
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(67, 97, 238, 0.3);
}

.check-in-btn i {
    font-size: 32px;
}

.btn-text {
    font-size: 14px;
    display: block;
}

/* For smaller screens */
@media (max-width: 480px) {
    .check-in-btn {
        width: 150px;
        height: 150px;
        margin: 50px auto auto auto;
    }
    
    .check-in-btn i {
        font-size: 28px;
    }
    
    .btn-text {
        font-size: 12px;
    }
}
    </style>
</head>
<body>
    <div class="container">
        <h3><i class="fas fa-user-circle"></i> Welcome, <span id="user-name-header"></span></h3>

        <div class="date-display" id="current-date"></div>
        <!-- Digital Clock -->
        <div class="digital-clock" id="digitalClock">
            <span id="clock-hours">00</span>
            <span class="clock-colon">:</span>
            <span id="clock-minutes">00</span>
            <span class="clock-colon">:</span>
            <span id="clock-seconds">00</span>
        </div>
        <h4><i class="fas fa-calendar-check"></i> Attendance</h4>
        <!-- Attendance Section -->
        <div class="section">
            <p><strong>Email:</strong> <span id="user-email">Loading...</span></p>
            <input type="hidden" id="employee-id" name="employee-id">
            <input type="hidden" id="latitude" name="latitude">
            <input type="hidden" id="longitude" name="longitude">
            
            <div class="status-container">
                <div id="statusMessage" class="status-message alert-info">
                    <i class="fas fa-info-circle status-icon"></i>
                    <div class="status-text">Waiting for location...</div>
                    <div class="status-details"></div>
                </div>
            </div>
            
            <button class="check-in-btn" onclick="markAttendance()">
                <i class="fas fa-check-circle"></i>
                <span class="btn-text">Check In</span>
            </button>
        </div>

        <!-- Profile Section -->
        <div class="section">
            <div id="profile-section">
            </div>
            <button class="btn-logout" onclick="logout()">
                <i class="fas fa-sign-out-alt"></i> Logout
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
            getLocation(); // Auto-fetch location when page loads
            updateClock(); // Initialize digital clock
            setInterval(updateClock, 1000); // Update clock every second
        });

        // Digital Clock Function
        function updateClock() {
            const now = new Date();
            const hours = String(now.getHours()).padStart(2, '0');
            const minutes = String(now.getMinutes()).padStart(2, '0');
            const seconds = String(now.getSeconds()).padStart(2, '0');
            
            $('#clock-hours').text(hours);
            $('#clock-minutes').text(minutes);
            $('#clock-seconds').text(seconds);
        // Update date
        const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
            document.getElementById('current-date').textContent = now.toLocaleDateString(undefined, options);
        }


        function getProfileData() {
            let token = localStorage.getItem('authToken');
            if (!token) {
                showAlert('error', 'User not authenticated. Redirecting to login.');
                setTimeout(() => {
                    window.location.href = 'http://localhost/test/Attendance_Sample/AttendanceApplication/public/loginUI';
                }, 1500);
                return;
            }

            $.ajax({
                url: 'http://localhost/test/Attendance_Sample/AttendanceApplication/public/api/auth/profile',
                type: 'GET',
                headers: { 'Authorization': 'Bearer ' + token },
                success: function(response) {
                    $('#user-name-header').text(response.data.name || 'User');
                    $('#user-email').text(response.data.email || 'N/A');
                    $('#employee-id').val(response.data.id);
                },
                error: function() {
                    showAlert('error', 'Failed to fetch profile data. Please login again.');
                    localStorage.removeItem('authToken');
                    setTimeout(() => {
                        window.location.href = 'http://localhost/test/Attendance_Sample/AttendanceApplication/public/loginUI';
                    }, 1500);
                }
            });
        }

        function logout() {
            localStorage.removeItem('authToken');
            showAlert('success', 'Logging out...');
            setTimeout(() => {
                window.location.href = 'http://localhost/test/Attendance_Sample/AttendanceApplication/public/loginUI';
            }, 1000);
        }

        function showAlert(type, message, details = '') {
            // Hide all status messages first
            $('.status-message').removeClass('active');
            
            // Configure based on alert type
            let icon, alertClass;
            switch(type) {
                case 'success':
                    icon = 'fa-check-circle';
                    alertClass = 'alert-success';
                    break;
                case 'error':
                    icon = 'fa-exclamation-triangle';
                    alertClass = 'alert-error';
                    break;
                case 'warning':
                    icon = 'fa-spinner fa-spin';
                    alertClass = 'alert-warning';
                    break;
                default:
                    icon = 'fa-info-circle';
                    alertClass = 'alert-info';
            }
            
            // Update the status message
            const statusMessage = $('#statusMessage');
            statusMessage.removeClass().addClass(`status-message ${alertClass}`);
            statusMessage.html(`
                <i class="fas ${icon} status-icon"></i>
                <div class="status-text">${message}</div>
                ${details ? `<div class="status-details">${details}</div>` : ''}
            `);
            
            // Show with animation
            setTimeout(() => {
                statusMessage.addClass('active');
            }, 10);
        }

        async function getLocation() {
            showAlert('warning', 'Getting your location...');
            
            if (!navigator.geolocation) {
                showAlert('error', 'Geolocation is not supported by your browser.');
                return null;
            }

            return new Promise((resolve, reject) => {
                navigator.geolocation.getCurrentPosition(
                    (position) => {
                        const latitude = position.coords.latitude.toFixed(6);
                        const longitude = position.coords.longitude.toFixed(6);

                        $('#latitude').val(latitude);
                        $('#longitude').val(longitude);
                        
                        showAlert('success', 'Location detected', `${latitude}, ${longitude}`);
                        resolve({ latitude, longitude });
                    },
                    (error) => {
                        let errorMessage = 'Location access denied. Please enable location services.';
                        if (error.code === error.TIMEOUT) {
                            errorMessage = 'Location request timed out. Please try again.';
                        }
                        showAlert('error', errorMessage);
                        reject(error);
                    },
                    { 
                        enableHighAccuracy: true, 
                        timeout: 10000,
                        maximumAge: 0
                    }
                );
            });
        }

        async function markAttendance() {
            try {
                let employeeId = $('#employee-id').val();
                if (!employeeId) {
                    showAlert('error', 'User information not loaded. Please refresh the page.');
                    return;
                }

                // Get the location and wait for it
                const location = await getLocation();
                if (!location) {
                    showAlert('error', 'Cannot mark attendance without location.');
                    return;
                }

                let postData = {
                    user_id: employeeId,
                    latitude: location.latitude,
                    longitude: location.longitude
                };

                let token = localStorage.getItem('authToken');
                if (!token) {
                    showAlert('error', 'Session expired. Redirecting to login.');
                    setTimeout(() => {
                        window.location.href = 'http://localhost/test/Attendance_Sample/AttendanceApplication/public/loginUI';
                    }, 1500);
                    return;
                }

                showAlert('warning', 'Submitting attendance...');
                
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
                    showAlert('success', responseData.message || 'Attendance marked successfully!');
                } else {
                    showAlert('error', responseData.message || 'Failed to mark attendance.');
                }
            } catch (error) {
                console.error("Error submitting attendance:", error);
                showAlert('error', 'Error submitting attendance. Please try again.');
            }
        }
    </script>
</body>
</html>