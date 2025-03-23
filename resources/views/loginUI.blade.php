<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>User Login</title>
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
        
        #login-box {
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
    <div id="login" class="container">
        <div class="row justify-content-center w-100">
            <div class="col-12 col-sm-10 col-md-8 col-lg-6 d-flex justify-content-center">
                <div id="login-box">
                    <form name="frm_login" id="frm_login">
                        @csrf
                        <h3 class="text-center">Login</h3>
                        <div class="mb-3">
                            <label for="username">Email:</label>
                            <input type="email" class="form-control" id="email" name="email">
                        </div>
                        <div class="mb-3">
                            <label for="password">Password:</label>
                            <input type="password" class="form-control" id="password" name="password">
                        </div>
                        <div class="mb-3 d-grid">
                            <button type="button" class="btn btn-primary" onclick="login()">Sign In</button>
                        </div>
                        <div id="err" class="text-center"></div>
                        <div class="mb-3 d-grid">
                            <button type="button" class="btn btn-secondary" onclick="window.location.href='https://attendance-app-main-bzzr3a.laravel.cloud/registerUI'">Register</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        function login() {
            let email = $('#email').val();
            let password = $('#password').val();
            let deviceId = getDeviceId();
            
            $.ajax({
                url: 'https://attendance-app-main-bzzr3a.laravel.cloud/api/auth/login',
                type: 'POST',
                contentType: 'application/json',
                data: JSON.stringify({ email: email, password: password, device_id: deviceId }),
                success: function(response) {
                    if (response.data.token) {
                        localStorage.setItem('authToken', response.data.token);
                        window.location.href = 'https://attendance-app-main-bzzr3a.laravel.cloud/dashboard';
                    }
                },
                error: function(xhr) {
                    console.log(xhr.responseJSON.message);
                    $('#err').text(xhr.responseJSON.message || 'Login failed.');
                }
            });
        }

        function getDeviceId() {
            let deviceId = localStorage.getItem('device_id');
            if (!deviceId) {
                deviceId = crypto.randomUUID();
                localStorage.setItem('device_id', deviceId);
            }
            return deviceId;
        }
    </script>
</body>
</html>
