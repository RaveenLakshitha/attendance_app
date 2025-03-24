<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>User Registration</title>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free/js/all.min.js"></script>
    <style>
        body {
            margin: 0;
            padding: 0;
            background-color: #e3f2fd;
            font-family: 'Roboto', sans-serif;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        #register-box {
            max-width: 400px;
            width: 100%;
            padding: 30px;
            background-color: #ffffff;
            border-radius: 15px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
        }
        .btn-primary {
            background-color: #4CAF50;
            border: none;
            transition: background 0.3s ease;width: 100%;
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
        .btn-primary:hover {
            background-color: #033656;
        }
        .btn-secondary {
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
        .btn-secondary:hover {
            background-color: #033656;
        }
        .form-control {
            border: 2px solid #ddd;
            border-radius: 8px;
            padding: 12px;
        }
        .form-control:focus {
            border-color: #1565c0;
            box-shadow: 0 0 5px rgba(76, 175, 80, 0.5);
        }
        #err {
            margin-top: 10px;
            color: #f44336;
        }
    </style>
</head>
<body>
    <div id="register" class="container">
        <div class="row justify-content-center w-100">
            <div class="col-12 col-sm-10 col-md-8 col-lg-6 d-flex justify-content-center">
                <div id="register-box">
                    <form name="frm_register" id="frm_register">
                        @csrf
                        <h3 class="text-center">Register</h3>
                        <div class="mb-3">
                            <label for="name">Name:</label>
                            <input type="text" class="form-control" id="name" name="name">
                        </div>
                        <div class="mb-3">
                            <label for="email">Email:</label>
                            <input type="email" class="form-control" id="email" name="email">
                        </div>
                        <div class="mb-3">
                            <label for="password">Password:</label>
                            <input type="password" class="form-control" id="password" name="password">
                        </div>
                        <div class="mb-3 d-grid">
                            <button type="button" class="btn btn-primary" onclick="register()">Sign Up</button>
                        </div>
                        <div id="error-msg" class="text-danger text-center"></div>
                        <div class="mb-3 d-grid">
                            <button type="button" class="btn btn-secondary" onclick="window.location.href='https://attendance-app-main-bzzr3a.laravel.cloud/loginUI'">Back to Login</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        function register() {
            let name = $('#name').val();
            let email = $('#email').val();
            let password = $('#password').val();
            let deviceId = getDeviceId();// Generate a unique ID for the browser session

            console.log(deviceId);
            $.ajax({
                url: 'https://attendance-app-main-bzzr3a.laravel.cloud/api/auth/register',
                type: 'POST',
                contentType: 'application/json',
                data: JSON.stringify({ name: name, email: email, password: password, device_id: deviceId }),
                success: function(response) {
                    if (response.status === 'success') {
                        alert('Registration successful! Please log in.');
                        window.location.href = 'https://attendance-app-main-bzzr3a.laravel.cloud/loginUI';
                    }
                },
                error: function(xhr) {
                    console.log(xhr.responseJSON.message);
                    $('#error-msg').text(xhr.responseJSON.message || 'Registration failed.');
                }
            });
        }

        function getDeviceId() {
            let deviceId = localStorage.getItem('device_id');
            
            if (!deviceId) {
                deviceId = crypto.randomUUID();  // Generate a unique ID (first-time users)
                localStorage.setItem('device_id', deviceId);
            }

            return deviceId;
        }
        
    </script>
</body>
</html>
