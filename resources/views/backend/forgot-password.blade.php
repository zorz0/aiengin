<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Forgot password</title>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <!-- Custom fonts for this template-->
    <link href="{{ asset('backend/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <!-- Custom styles for this template-->
    <link href="{{ asset('backend/css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('backend/css/login.css') }}" rel="stylesheet">
</head>

<body class="bg-gradient-primary">

<div class="container">
    <!-- Outer Row -->
    <div class="row justify-content-center">
        <div class="col-xl-10 col-lg-12 col-md-9">
            <div class="card o-hidden border-0 shadow-lg my-5">
                <div class="card-body p-0">
                    <!-- Nested Row within Card Body -->
                    <div class="row">
                        <div class="col-lg-6 d-none d-lg-block bg-password-image"></div>
                        <div class="col-lg-6">
                            <div class="p-5">
                                @if (session('status') && session('status') == 'success')
                                    <div class="alert alert-success">
                                        {{ session('message') }}
                                    </div>
                                @elseif (session('status') && session('status') == 'failed')
                                    <div class="alert alert-danger">
                                        {{ session('message') }}
                                    </div>
                                @endif
                                <div class="text-center">
                                    <h1 class="h4 text-gray-900 mb-2">{{ __('admin.forgot_password_title') }}</h1>
                                    <p class="mb-4">{{ __('admin.forgot_password_text') }}</p>
                                </div>
                                @if (count($errors) >0)
                                    <div class="alert alert-danger" role="alert">
                                        <h4 class="alert-heading">{{ __('admin.validation_errors') }}</h4>
                                        <ul>
                                            @foreach($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                                <form class="user" method="post" action="{{ route('backend.forgot-password.post') }}">
                                    @csrf
                                    <div class="form-group">
                                        <input type="email" name="email" class="form-control form-control-user" id="exampleInputEmail" aria-describedby="emailHelp" placeholder="{{ __('admin.email_address') }}">
                                    </div>
                                    <button class="btn btn-primary btn-user btn-block">{{ __('admin.reset_password') }}</button>
                                </form>
                                <hr>
                                <div class="text-center">
                                    <a class="small" href="{{ route('backend.login') }}">{{ __('admin.already_have_account') }}</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Bootstrap core JavaScript-->
<script src="{{ asset('backend/vendor/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('backend/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- Core plugin JavaScript-->
<script src="{{ asset('backend/vendor/jquery-easing/jquery.easing.min.js') }}"></script>
<!-- Custom scripts for login page -->
<script src="{{ asset('backend/js/login.js') }}"></script>
</body>
</html>
