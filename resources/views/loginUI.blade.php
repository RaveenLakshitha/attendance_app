<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>User Login</title>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free/js/all.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-color: #4361ee;
            --primary-hover: #3a56d4;
            --secondary-color: #3f37c9;
            --accent-color: #4cc9f0;
            --light-bg: #f8f9fa;
            --card-shadow: 0 10px 30px -15px rgba(0, 0, 0, 0.1);
        }
        
        body {
            margin: 0;
            padding: 0;
            background: linear-gradient(135deg, #f5f7fa 0%, #e4f1fe 100%);
            font-family: 'Poppins', sans-serif;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        #login-box {
            max-width: 420px;
            width: 100%;
            padding: 40px;
            background-color: #ffffff;
            border-radius: 16px;
            box-shadow: var(--card-shadow);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        
        .login-header {
            text-align: center;
            margin-bottom: 30px;
        }
        
        .login-header h3 {
            color: var(--primary-color);
            font-weight: 600;
            margin-bottom: 10px;
        }
        
        .login-header p {
            color: #6c757d;
            font-size: 0.9rem;
        }
        
        .form-group {
            position: relative;
            margin-bottom: 1.5rem;
        }
        
        .form-control {
            border: 2px solid #e9ecef;
            border-radius: 10px;
            padding: 12px 15px 12px 40px;
            height: 48px;
            font-size: 0.9rem;
            transition: all 0.3s ease;
            background-color: var(--light-bg);
        }
        
        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.1);
            background-color: #fff;
        }
        
        .input-icon {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #6c757d;
            font-size: 1rem;
            transition: all 0.3s ease;
        }
        
        .form-control:focus + .input-icon {
            color: var(--primary-color);
        }
        
        .btn-primary {
            width: 100%;
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            color: #fff;
            border: none;
            padding: 12px 20px;
            border-radius: 10px;
            cursor: pointer;
            font-weight: 500;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            height: 48px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(67, 97, 238, 0.2);
        }
        
        .btn-primary:hover {
            background: linear-gradient(135deg, var(--primary-hover) 0%, #3a56d4 100%);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(67, 97, 238, 0.3);
        }
        
        .btn-secondary {
            width: 100%;
            background-color: transparent;
            color: var(--primary-color);
            border: 2px solid var(--primary-color);
            padding: 12px 20px;
            border-radius: 10px;
            cursor: pointer;
            font-weight: 500;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            height: 48px;
            transition: all 0.3s ease;
            margin-top: 10px;
        }
        
        .btn-secondary:hover {
            background-color: rgba(67, 97, 238, 0.1);
        }
        
        #err {
            margin-top: 15px;
            color: #f44336;
            font-size: 0.9rem;
            text-align: center;
            padding: 10px;
            border-radius: 8px;
            background-color: rgba(244, 67, 54, 0.1);
        }
        
        .divider {
            display: flex;
            align-items: center;
            margin: 20px 0;
            color: #6c757d;
            font-size: 0.8rem;
        }
        
        .divider::before,
        .divider::after {
            content: "";
            flex: 1;
            border-bottom: 1px solid #e9ecef;
        }
        
        .divider::before {
            margin-right: 10px;
        }
        
        .divider::after {
            margin-left: 10px;
        }
        
        .forgot-password {
            text-align: right;
            margin-top: -10px;
            margin-bottom: 20px;
        }
        
        .forgot-password a {
            color: #6c757d;
            font-size: 0.8rem;
            text-decoration: none;
            transition: color 0.3s ease;
        }
        
        .forgot-password a:hover {
            color: var(--primary-color);
        }
    </style>
</head>
<body>
    <div id="login" class="container">
        <div class="row justify-content-center w-100">
            <div class="col-12 col-sm-10 col-md-8 col-lg-6 d-flex justify-content-center">
                <div id="login-box">
                    <div class="login-header">
                        <h3>Welcome Back</h3>
                    </div>
                    <form name="frm_login" id="frm_login">
                        @csrf
                        <div class="form-group">
                            <i class="fas fa-envelope input-icon"></i>
                            <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email">
                        </div>
                        <div class="form-group">
                            <i class="fas fa-lock input-icon"></i>
                            <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password">
                        </div>
                        <div class="mb-3 d-grid">
                            <button type="button" class="btn btn-primary" onclick="login()">
                                <i class="fas fa-sign-in-alt"></i> Sign In
                            </button>
                        </div>
                        <div id="err" class="text-center"></div>
                        <div class="divider"></div>
                        <div class="mb-3 d-grid">
                            <button type="button" class="btn btn-secondary" onclick="window.location.href='http://localhost/test/Attendance_Sample/AttendanceApplication/public/registerUI'">
                                <i class="fas fa-user-plus"></i> Create Account
                            </button>
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
            
            // Basic validation
            if (!email || !password) {
                $('#err').text('Please fill in all fields');
                return;
            }
            
            // Show loading state
            const loginBtn = $('.btn-primary');
            loginBtn.html('<i class="fas fa-spinner fa-spin"></i> Signing in...');
            loginBtn.prop('disabled', true);
            
            $.ajax({
                url: 'http://localhost/test/Attendance_Sample/AttendanceApplication/public/api/auth/login',
                type: 'POST',
                contentType: 'application/json',
                data: JSON.stringify({ email: email, password: password, device_id: deviceId }),
                success: function(response) {
                    console.log(response);
                    if (response.data.token) {
                        localStorage.setItem('authToken', response.data.token);
                        window.location.href = 'http://localhost/test/Attendance_Sample/AttendanceApplication/public/dashboard';
                    }
                },
                error: function(xhr) {
                    console.log(xhr.responseJSON.message);
                    $('#err').text(xhr.responseJSON.message || 'Login failed. Please try again.');
                },
                complete: function() {
                    loginBtn.html('<i class="fas fa-sign-in-alt"></i> Sign In');
                    loginBtn.prop('disabled', false);
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
        
        // Add animation to inputs on focus
        $(document).ready(function() {
            $('.form-control').focus(function() {
                $(this).parent().find('.input-icon').css('transform', 'translateY(-50%) scale(1.2)');
            }).blur(function() {
                $(this).parent().find('.input-icon').css('transform', 'translateY(-50%) scale(1)');
            });
        });
    </script>
</body>
</html>