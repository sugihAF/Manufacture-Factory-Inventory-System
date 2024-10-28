<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>Login | MYSpareParts</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="{{ asset('frontend/assets/images/favicon.ico') }}">

    <!-- Bootstrap and Template CSS -->
    <link href="{{ asset('frontend/assets/css/bootstrap.min.css') }}" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <link href="{{ asset('frontend/assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('frontend/assets/css/app.min.css') }}" id="app-style" rel="stylesheet" type="text/css" />
</head>

<body class="auth-body-bg">
    <div class="bg-overlay"></div>
    <div class="wrapper-page">
        <div class="container-fluid p-0">
            <div class="card">
                <div class="card-body">
                    <div class="text-center mt-4">
                        <div class="mb-3">
                            <a href="{{ url('/') }}" class="auth-logo">
                                <img src="{{ asset('frontend/assets/images/auth-login-light.png') }}" height="40" class="logo-dark mx-auto" alt="">
                                <!-- <img src="{{ asset('frontend/assets/images/logo-myspareparts.png') }}" height="30" class="logo-light mx-auto" alt=""> -->
                            </a>
                        </div>
                    </div>

                    <h4 class="text-muted text-center font-size-15"><b>Sign In</b></h4>

                    <div class="p-3">
                        <form method="POST" action="{{ route('login.submit') }}">
                            @csrf

                            <!-- Email Field -->
                            <div class="form-group mb-3 row">
                                <div class="col-12">
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" placeholder="Email address" value="{{ old('email') }}" required autofocus>
                                    @error('email')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Password Field -->
                            <div class="form-group mb-3 row">
                                <div class="col-12">
                                    <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" placeholder="Password" required>
                                    @error('password')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <!-- User Type Selection -->
                            <div class="form-group mb-3 row">
                                <div class="col-12">
                                    <select class="form-select @error('user_type') is-invalid @enderror" id="user_type" name="user_type" required>
                                        <option value="">Login As</option>
                                        <option value="distributor" {{ old('user_type') == 'distributor' ? 'selected' : '' }}>Distributor</option>
                                        <option value="supervisor" {{ old('user_type') == 'supervisor' ? 'selected' : '' }}>Supervisor</option>
                                        <option value="factory" {{ old('user_type') == 'factory' ? 'selected' : '' }}>Factory</option>
                                    </select>
                                    @error('user_type')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Remember Me Checkbox
                            <div class="form-group mb-3 row">
                                <div class="col-12">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="customCheck1">
                                        <label class="form-label ms-1" for="customCheck1">Remember me</label>
                                    </div>
                                </div>
                            </div> -->

                            <!-- Submit Button -->
                            <div class="form-group mb-3 text-center row mt-3 pt-1">
                                <div class="col-12">
                                    <button type="submit" class="btn btn-info w-100 waves-effect waves-light">Log In</button>
                                </div>
                            </div>

                            <!-- Display Error and Success Messages -->
                            @if(session('error'))
                                <div class="alert alert-danger mt-3">
                                    {{ session('error') }}
                                </div>
                            @endif
                            @if(session('success'))
                                <div class="alert alert-success mt-3">
                                    {{ session('success') }}
                                </div>
                            @endif
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript -->
    <script src="{{ asset('frontend/assets/libs/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/libs/metismenu/metisMenu.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/libs/simplebar/simplebar.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/libs/node-waves/waves.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/app.js') }}"></script>
</body>
</html>
