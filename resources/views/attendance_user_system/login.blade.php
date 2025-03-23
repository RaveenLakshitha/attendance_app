<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css">
<style>
body {
  margin: 0;
  padding: 0;
  background-color: #fcfcfc;
  height: 100vh;
  display: flex;
  align-items: center;
  justify-content: center;
}
#login-box {
  max-width: 400px;
  width: 100%;
  padding: 20px;
  border: 1px solid #000000;
  background-color: #EAEAEA;
  border-radius: 10px;
  box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
  margin: auto;
}
.container {
  display: flex;
  justify-content: center;
  align-items: center;
  height: 100vh;
}
.has-error {
  border: 2px solid rgb(0, 0, 0);
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
                            <label for="username">Username:</label>
                            <input type="text" class="form-control" id="username" name="username">
                        </div>
                        <div class="mb-3">
                            <label for="password">Password:</label>
                            <input type="password" class="form-control" id="password" name="password">
                        </div>
                        <div class="mb-3 d-grid">
                            <button type="button" class="btn btn-primary" onclick="login()">Sign In</button>
                        </div>
                        <div id="err" class="text-danger text-center"></div>
                        <div class="mb-3 d-grid">
                            <button type="button" class="btn btn-secondary" onclick="window.location.href='/register'">Register</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
<script>
    function login() {
        $('#username, #password').removeClass('has-error');
        if ($('#username').val() === "") {
            $('#username').addClass('has-error');
            return;
        }
        if ($('#password').val() === "") {
            $('#password').addClass('has-error');
            return;
        }
        var data = $("#frm_login").serialize();
        $.ajaxSetup({
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
        });
        $.ajax({
            type: 'POST',
            url: '/check',
            data: data,
            success: function(response) {
                if (response == 1) {
                    window.location.replace('/home');
                } else if (response == 3) {
                    $("#err").text("Username or Password Incorrect. Please Check").fadeIn('slow');
                }
            }
        });
    }
</script>
</body>
</html>