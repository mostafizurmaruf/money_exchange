<!DOCTYPE html><html lang="en"><head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- =======Title===== -->
    <title>Cryptocox</title>
    <!-- fevicon -->
    <link rel="icon" type="image/x-icon" href="{{asset('user')}}/images/favicon.png">
    <!-- =====Bootstrap CSS==== -->
    <link rel="stylesheet" href="{{asset('user')}}/css/bootstrap.min.css">
    <!-- =====owl carousel==== -->
    <link rel="stylesheet" href="{{asset('user')}}/css/owl.carousel.min.css">
    <!-- =====owl carousel owl theme -->
    <link rel="stylesheet" href="{{asset('user')}}/css/owl.theme.default.min.css">
    <!-- bootstrap icons -->
    <link rel="stylesheet" href="{{asset('user')}}/css/bootstrap-icons.min.css">
    <!-- scrollup css -->
    <link rel="stylesheet" href="{{asset('user')}}/css/image.css">
    <!-- =====Font Awesome==== -->
    <link rel="stylesheet" href="{{asset('user')}}/css/all.min.css">
    <!-- ======Custom CSS -->
    <link rel="stylesheet" href="{{asset('user')}}/css/style.css">
    <!-- ======Responsive CSS -->
    <link rel="stylesheet" href="{{asset('user')}}/css/responsive.css">

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @if(Route::currentRouteName() === 'user.index')
    @else
    <style type="text/css">
        @media (max-width: 460px) {
            header {
                padding: 0;
            }
        }
        header {
            position: absolute;
            left: 0;
            right: 0;
            padding: 0;
            background: transparent;
        }
    </style>
    @endif
</head>

<body>

    <!-- ==========Header Area Start============ -->
    <header class="header-main-block ">
        <nav class="navbar navbar-expand-lg" style="@if(Route::currentRouteName() !== 'user.index') background-color: #0e1849; @endif">
            <div class="container">
                <a class="navbar-brand fade-effect" data-fade-direction="top" data-fade-time="2" href="{{route('user.index')}}">
                    <img src="{{asset('user')}}/images/logo.png" alt="site-logo">
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <i class="fas fa-bars"></i>
                </button>
                @if(!Auth::check())
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto text-md-center">
                        <li class="nav-item">
                            <a class="nav-link fade-effect" data-fade-direction="top" data-fade-time="0.75" href="#about">About Us</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link fade-effect" data-fade-direction="top" data-fade-time="1" href="{{route('user.login')}}">Login</a>
                        </li>
                    </ul>
                </div>
                @else
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto text-md-center">
                        <li class="nav-item">
                            <a class="nav-link fade-effect" data-fade-direction="top" data-fade-time="0.75" href="{{route('user.dashboard')}}">Dashboard</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link fade-effect" data-fade-direction="top" data-fade-time="1.5" href="{{route('user.profile')}}">Profile</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link fade-effect" data-fade-direction="top" data-fade-time="1.5" href="{{route('user.transection')}}">Transection</a>
                        </li>
                        <li class="nav-item">
                            <a class="btn btn-primary fade-effect" data-fade-direction="top" data-fade-time="0.75" href="{{route('user.logout')}}">Logout</a>
                        </li>
                    </ul>
                </div>
                @endif
            </div>
        </nav>
    </header>
    <!-- ==========Header Area End============ -->