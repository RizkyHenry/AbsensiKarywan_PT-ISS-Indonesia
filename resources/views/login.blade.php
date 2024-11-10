<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <style>
        body {
            background-color: #f0f8ff;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background: url('/from-login.jpg') no-repeat center center fixed;
            background-size: cover;
        }

        .login-form {
            max-width: 100%;
            width: 400px;
            padding: 20px;
            background-color: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            color: white;
            margin: 0 15px;
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
            margin-top: 20px;
            max-width: 100%;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #004085;
        }

        h2 {
            color: white;
            text-align: center;
            margin-bottom: 30px;
        }

        .alert-success {
            --bs-alert-color: #fff;
            --bs-alert-bg: #253aaa;
            --bs-alert-border-color: #fff;
            text-align: center;
        }

        .alert-warning {
            --bs-alert-bg: #e81111;
            --bs-alert-color: #fff;
        }
    </style>
</head>

<body>
    <div class="container d-flex justify-content-center align-items-center vh-100">
        <form method="POST" action="{{ route('login') }}" class="login-form shadow-sm rounded col-12 col-sm-10 col-md-8 col-lg-6">
            @if (Session::has('success'))
                <div id="success-alert" class="alert alert-success">
                    {{ Session::get('success') }}
                </div>
            @endif
            @if (Session::has('fail'))
                <div id="fail-alert" class="alert alert-warning">
                    {{ Session::get('fail') }}
                </div>
            @endif
            @csrf

            <h2 class="text-center mb-4">LOGIN</h2>
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control mb-2" id="username" name="username" required>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <div class="input-group">
                    <input type="password" class="form-control" id="password" name="password" required>
                    <button type="button" class="btn btn-outline-secondary" id="togglePasswordEdit" style="border-left: none;">
                        <i class="fa fa-eye" id="toggleIconEdit"></i>
                    </button>
                </div>
            </div>
            
            <button type="submit" class="btn btn-primary w-100">Login</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4"
        crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/js/all.min.js"></script>

    <script>
        // Efek mata untuk toggle visibility password
        document.getElementById('togglePasswordEdit').addEventListener('click', function () {
            const passwordInput = document.getElementById('password');
            const toggleIcon = document.getElementById('toggleIconEdit');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleIcon.classList.remove('fa-eye');
                toggleIcon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                toggleIcon.classList.remove('fa-eye-slash');
                toggleIcon.classList.add('fa-eye');
            }
        });

        // Menghilangkan alert setelah beberapa detik
        const successAlert = document.getElementById('success-alert');
        if (successAlert) {
            setTimeout(() => {
                successAlert.style.display = 'none';
            }, 3000); // hilangkan setelah 3 detik
        }

        const failAlert = document.getElementById('fail-alert');
        if (failAlert) {
            setTimeout(() => {
                failAlert.style.display = 'none';
            }, 3000); // hilangkan setelah 3 detik
        }
    </script>
</body>

</html>
