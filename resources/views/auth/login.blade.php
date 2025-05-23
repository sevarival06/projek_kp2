<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>AMS - Login</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('img/logo.png') }}">

    <!-- Font & Icon -->
    <link href="{{ asset('template/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" rel="stylesheet">

    <!-- SB Admin 2 -->
    <link href="{{ asset('template/css/sb-admin-2.min.css') }}" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(135deg, #4e73df, #224abe);
            font-family: 'Poppins', sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
        }

        .card {
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
        }

        .bg-login-image {
            background: url('{{ asset("template/img/login-bg.jpg") }}') center center / cover no-repeat;
            position: relative;
        }

        .bg-login-image::after {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, #4e73df, #7f7fd5);
        }

        .login-branding {
            position: relative;
            z-index: 1;
            color: #fff;
            text-align: center;
            padding: 3rem 2rem;
        }

        .login-branding img {
            width: 100px;
            margin-bottom: 1rem;
        }

        .login-branding h2 {
            font-weight: 700;
            font-size: 1.6rem;
        }

        .login-content {
            padding: 3rem;
        }

        .login-content h1 {
            font-weight: 700;
            font-size: 1.5rem;
            color: #343a40;
        }

        .form-control {
            border-radius: 12px;
            padding: 0.75rem 1rem;
        }

        .input-group-text {
            background-color: transparent;
            border: none;
        }

        .form-control:focus {
            box-shadow: 0 0 0 0.15rem rgba(78, 115, 223, 0.3);
        }

        .btn-primary {
            border-radius: 12px;
            font-weight: 600;
            background: linear-gradient(to right, #4e73df, #2e59d9);
            transition: 0.3s;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            background: linear-gradient(to right, #2e59d9, #4e73df);
        }

        .btn-outline-primary {
            border-radius: 12px;
            font-weight: 600;
            transition: 0.3s;
        }

        .divider {
            display: flex;
            align-items: center;
            text-align: center;
            margin: 2rem 0;
        }

        .divider::before,
        .divider::after {
            content: '';
            flex: 1;
            border-bottom: 1px solid #dee2e6;
        }

        .divider span {
            margin: 0 1rem;
            font-size: 0.85rem;
            color: #6c757d;
        }

        @media (max-width: 991.98px) {
            .login-content {
                padding: 2rem;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-10 col-lg-12">
                <div class="card my-5 animate__animated animate__fadeIn">
                    <div class="row no-gutters">
                        <div class="col-lg-5 d-none d-lg-block bg-login-image">
                            <div class="login-branding">
                                <img src="{{ asset('img/logo.png') }}" alt="Logo AMS">
                                <h2 class="mt-3">Aplikasi Manajemen Surat</h2>
                                <p>Kelola surat dengan lebih mudah dan efisien</p>
                            </div>
                        </div>
                        <div class="col-lg-7">
                            <div class="login-content">
                                <div class="text-center mb-4">
                                    <img src="{{ asset('img/logo.png') }}" alt="Logo" class="d-lg-none mb-2" style="width: 60px;">
                                    <h1 class="h4">Selamat Datang!</h1>
                                    <p class="text-muted mb-0">Silakan masuk untuk melanjutkan</p>
                                </div>

                                @if (session('error'))
                                <div class="alert alert-danger animate__animated animate__fadeIn">
                                    <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
                                </div>
                                @endif

                                <form method="POST" action="{{ route('login') }}">
                                    @csrf
                                    <div class="form-group">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-user"></i></span>
                                            </div>
                                            <input type="text" name="username" class="form-control" placeholder="Username" required autofocus value="{{ old('username') }}">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                            </div>
                                            <input type="password" name="password" class="form-control" placeholder="Password" required>
                                        </div>
                                    </div>

                                    <!-- <div class="form-group">
                                        <div class="custom-control custom-checkbox small">
                                            <input type="checkbox" class="custom-control-input" id="remember">
                                            <label class="custom-control-label" for="remember">Ingat saya</label>
                                        </div>
                                    </div> -->

                                    <button type="submit" class="btn btn-primary btn-block">
                                        <i class="fas fa-sign-in-alt mr-2"></i>Masuk
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="text-center text-white">
                    <small>Copyright &copy; AMS {{ date('Y') }}</small>
                </div>
            </div>
        </div>
    </div>

    <!-- Script -->
    <script src="{{ asset('template/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('template/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('template/js/sb-admin-2.min.js') }}"></script>
</body>
</html>
