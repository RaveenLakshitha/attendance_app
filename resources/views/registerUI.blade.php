<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>User Registration</title>
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
        
        #register-box {
            max-width: 420px;
            width: 100%;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 16px;
            box-shadow: var(--card-shadow);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        
        .register-header {
            text-align: center;
            margin-bottom: 30px;
        }
        
        .register-header h3 {
            color: var(--primary-color);
            font-weight: 600;
            margin-bottom: 10px;
        }
        
        .register-header p {
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
        
        #error-msg {
            margin-top: 15px;
            color: #f44336;
            font-size: 0.9rem;
            text-align: center;
            padding: 10px;
            border-radius: 8px;
            background-color: rgba(244, 67, 54, 0.1);
        }
        
        .password-strength {
            margin-top: 5px;
            font-size: 0.8rem;
            color: #6c757d;
        }
        
        .strength-meter {
            height: 5px;
            background-color: #e9ecef;
            border-radius: 5px;
            margin-top: 5px;
            overflow: hidden;
        }
        
        .strength-meter-fill {
            height: 100%;
            width: 0%;
            transition: width 0.3s ease, background-color 0.3s ease;
        }
    </style>
</head>
<body>
    <div id="register" class="container">
        <div class="row justify-content-center w-100">
            <div class="col-12 col-sm-10 col-md-8 col-lg-6 d-flex justify-content-center">
                <div id="register-box">
                    <div class="register-header">
                        <h3>Create Your Account</h3>
                    </div>
                    <form name="frm_register" id="frm_register">
                        @csrf
                        <div class="form-group">
                            <i class="fas fa-user input-icon"></i>
                            <input type="text" class="form-control" id="name" name="name" placeholder="User name">
                        </div>
                        <div class="form-group">
                            <i class="fas fa-envelope input-icon"></i>
                            <input type="email" class="form-control" id="email" name="email" placeholder="Email">
                        </div>
                        <div class="form-group">
                            <i class="fas fa-lock input-icon"></i>
                            <input type="password" class="form-control" id="password" name="password" placeholder="Password">
                            {{-- <div class="password-strength">
                                <div>Password strength: <span id="strength-text">Weak</span></div>
                                <div class="strength-meter">
                                    <div class="strength-meter-fill" id="strength-meter"></div>
                                </div>
                            </div> --}}
                        </div>
                        <div class="mb-3 d-grid">
                            <button type="button" class="btn btn-primary" onclick="register()">
                                <i class="fas fa-user-plus"></i> Sign Up
                            </button>
                        </div>
                        <div id="error-msg" class="text-center"></div>
                        <div class="mb-3 d-grid">
                            <button type="button" class="btn btn-secondary" onclick="window.location.href='https://attendance-app-main-bzzr3a.laravel.cloud/loginUI'">
                                <i class="fas fa-sign-in-alt"></i> Back to Login
                            </button>
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
            let deviceId = getDeviceId();

            // Basic validation
            if (!name || !email || !password) {
                $('#error-msg').text('Please fill in all fields');
                return;
            }

            // Show loading state
            const registerBtn = $('.btn-primary');
            registerBtn.html('<i class="fas fa-spinner fa-spin"></i> Registering...');
            registerBtn.prop('disabled', true);
            
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
                    $('#error-msg').text(xhr.responseJSON.message || 'Registration failed. Please try again.');
                },
                complete: function() {
                    registerBtn.html('<i class="fas fa-user-plus"></i> Sign Up');
                    registerBtn.prop('disabled', false);
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

        // Password strength indicator
        $(document).ready(function() {
            $('#password').on('input', function() {
                const password = $(this).val();
                const strength = checkPasswordStrength(password);
                const meter = $('#strength-meter');
                const text = $('#strength-text');
                
                meter.css('width', strength.percentage + '%');
                meter.css('background-color', strength.color);
                text.text(strength.text);
                text.css('color', strength.color);
            });

            function checkPasswordStrength(password) {
                let strength = 0;
                const length = password.length;
                
                if (length === 0) return {
                    percentage: 0,
                    color: '#e9ecef',
                    text: ''
                };
                
                if (length > 0) strength += 20;
                if (length >= 8) strength += 20;
                if (/[A-Z]/.test(password)) strength += 20;
                if (/[0-9]/.test(password)) strength += 20;
                if (/[^A-Za-z0-9]/.test(password)) strength += 20;
                
                if (strength <= 40) {
                    return {
                        percentage: strength,
                        color: '#f44336',
                        text: 'Weak'
                    };
                } else if (strength <= 80) {
                    return {
                        percentage: strength,
                        color: '#ff9800',
                        text: 'Moderate'
                    };
                } else {
                    return {
                        percentage: strength,
                        color: '#4CAF50',
                        text: 'Strong'
                    };
                }
            }
            
            // Add animation to inputs on focus
            $('.form-control').focus(function() {
                $(this).parent().find('.input-icon').css('transform', 'translateY(-50%) scale(1.2)');
            }).blur(function() {
                $(this).parent().find('.input-icon').css('transform', 'translateY(-50%) scale(1)');
            });
        });
    </script>
</body>
</html>