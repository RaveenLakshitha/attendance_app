<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard</title>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free/js/all.min.js"></script>
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
        .status-message p {
            margin: 25px 0 25px 0;
            font-weight: bold;
        }
        #profile-section p {
            margin: 25px 0 25px 0;
        }
        #user-name-header {
            text-transform: uppercase;
        }
    </style>
</head>
<body>
    <div class="container">
        <h3><i class="fas fa-user-circle"></i> Welcome <span id="user-name-header"></h3>

        <div class="section">
            <h4><i class="fas fa-calendar-check icon-btn"></i> Attendance</h4>
            <input type="hidden" id="employee-id" name="employee-id">
            <input type="hidden" id="latitude" name="latitude">
            <input type="hidden" id="longitude" name="longitude">
            <div id="statusMessage" class="status-message"></div>
            <div id="distance" class="status-message"></div>
            <button onclick="markAttendance()">
                <i class="fas fa-check-circle icon-btn"></i> Mark Attendance
            </button>
        </div>

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


    <script>
        $(document).ready(function () {
            getProfileData();
        });

        function getProfileData() {
            let token = localStorage.getItem('authToken');
            if (!token) {
                alert('User not authenticated. Redirecting to login.');
                window.location.href = 'https://attendance-app-main-bzzr3a.laravel.cloud/loginUI';
                return;
            }

            $.ajax({
                url: 'https://attendance-app-main-bzzr3a.laravel.cloud/api/auth/profile',
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
                    window.location.href = 'https://attendance-app-main-bzzr3a.laravel.cloud/loginUI';
                }
            });
        }

        function logout() {
            localStorage.removeItem('authToken');
            window.location.href = 'https://attendance-app-main-bzzr3a.laravel.cloud/loginUI';
        }

        async function getLocation() {
        document.getElementById('statusMessage').innerHTML = "<p class='text-warning'>⏳ Getting location...</p>";

        if (!navigator.geolocation) {
            document.getElementById('statusMessage').innerHTML = "<p class='text-danger'>❗ Geolocation is not supported by your browser.</p>";
            return null;
        }

        return new Promise((resolve, reject) => {
            navigator.geolocation.getCurrentPosition(
                (position) => {
                    const latitude = position.coords.latitude;
                    const longitude = position.coords.longitude;

                    document.getElementById('latitude').value = latitude;
                    document.getElementById('longitude').value = longitude;
                    document.getElementById('statusMessage').innerHTML = `<p class='text-success'>✅ Location detected: ${latitude}, ${longitude}</p>`;

                    resolve({ latitude, longitude });
                },
                (error) => {
                    document.getElementById('statusMessage').innerHTML = `<p class='text-danger'>❗ Error: ${error.message}</p>`;
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
                window.location.href = 'https://attendance-app-main-bzzr3a.laravel.cloud/loginUI';
                return;
            }

            let response = await fetch("{{ url('https://attendance-app-main-bzzr3a.laravel.cloud/api/attendance') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "Accept": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}",
                    'Authorization': 'Bearer ' + token
                },
                body: JSON.stringify(postData),
                success: function(response) {
                    console.log(response);
                    alert('Attendance marked successfully.');
                },
                error: function(response) {
                    console.log(response);
                    alert('Failed to mark attendance.');
                }
            });

            let responseData = await response.json();
            
            if (response.ok) {
                document.getElementById('statusMessage').innerHTML = `<p class='text-success'>✅ ${responseData.message}</p>`;
            } else {
                document.getElementById('statusMessage').innerHTML = `<p class='text-danger'>❌ ${responseData.message}</p>`;
            }
        } catch (error) {
            console.error("❌ Error submitting attendance:", error);
            document.getElementById('statusMessage').innerHTML = "<p class='text-danger'>❌ Error submitting attendance. Try again.</p>";
        }
    }

    // Auto-fetch location when the page loads
    document.addEventListener("DOMContentLoaded", getLocation);

    </script>
</body>
</html>
