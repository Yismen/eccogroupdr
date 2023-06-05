<!DOCTYPE html>
<html lang="en" style="scroll-behavior: smooth;">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('css/fontawesome.min.css') }}">
    <!-- Theme style -->

    <link rel="stylesheet" href="{{ asset('css/adminlte.min.css') }}">
    @vite('resources/css/welcome.css')
</head>

<body class="hold-transition">
    @php
    $color = auth()->check() ? 'cyan' : 'indigo';
    @endphp
    <div class="wrapper">
        <div class="py-3">
            <div class="container">
                <nav class="navbar navbar-expand-lg navbar-light bg-white px-0">
                    <a class="navbar-brand text-bold text-{{ $color }}" href="#">Ecco Group DR</a>
                    <button class="navbar-toggler collapsed" type="button" data-toggle="collapse"
                        data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                        aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="navbar-collapse collapse" id="navbarSupportedContent" style="">
                        <ul class="mr-auto navbar-nav">
                            {{-- <li class="nav-item">
                                <a class="nav-link text-dark" href="#features">Features <span
                                        class="sr-only">(current)</span></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-dark" href="#testimonials">Testimonials</a>
                            </li> --}}
                        </ul>
                        <ul
                            class="align-items-lg-center align-items-start d-flex justify-content-between list-unstyled m-0 navbar-nav pt-3 pt-lg-0 text-decoration-none">
                            @auth
                            <li class="nav-item">
                                <a href="{{ route('home') }}" class="btn-sm btn bg-info">Visit</a>
                            </li>
                            <li class="ml-0 ml-lg-2 mt-2 mt-lg-0 nav-item text-dark text-sm">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <a href="{{ route('logout') }}"
                                        onclick="event.preventDefault(); this.closest('form').submit();">
                                        {{ __('Log Out') }}
                                    </a>
                                </form>
                            </li>
                            @else
                            <li class="nav-item">
                                <a href="{{ route('login') }}" class="btn-sm btn bg-{{ $color }}">Login</a>
                            </li>
                            <li class="ml-0 ml-lg-4 mt-2 mt-lg-0 nav-item">
                                <a href="{{ route('register') }}" class="text-dark">Register</a>
                            </li>
                        </ul>
                        @endauth

                    </div>
                </nav>
            </div>
        </div>

        <section class="align-items-center container d-flex flex-column justify-content-between my-5 py-5">
            <h1 class="text-bold display-4 text-center">
                Making Essential Information Accessible, Available, Reliable, Relevant.
            </h1>
            <h5 class="text-black-50 text-center">
                By offering timely and useful data</h5>
            <div class="mt-4">
                @auth
                <a href="{{ route('home') }}" class="bg-{{ $color }} btn btn-lg shadow shadow-sm">Visit App</a>
                @else
                <a href="{{ route('login') }}" class="bg-{{ $color }} btn btn-lg shadow shadow-sm">Log In</a>
                @endauth
                <a href="#features" class="ml-4 text-dark text-lg ">Learn More</a>
            </div>
        </section>

        <section class="container py-5" id="testimonials">
            <h3 class="text-bold text-center">
                Loved by users, essential for employees.
            </h3>
            <p class="text-black-50 text-center">Some of what people say about it!</p>

            <div class="mt-4 row" style=" row-gap: 15px; ">
                <div class="col-md-4">
                    <div class="p-4 rounded testimonials">
                        <div class="d-flex flex-column">
                            <div class="d-flex justify-content-start">
                                <i class="fa fa-quote-right mr-4 text-cyan" style="font-size: 1.5rem"></i>
                                <div class="d-flex flex-column">
                                    <h5 class="m-0 text-sm">Yismen Jorge</h5>
                                    <p class="text-black-50 text-sm">Workforce Manager</p>
                                </div>
                            </div>
                            <p class="text-sm">
                                Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ea maxime dolores perferendis
                                magnam itaque, in nesciunt veritatis..
                            </p>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="p-4 rounded testimonials">
                        <div class="d-flex flex-column">
                            <div class="d-flex justify-content-start">
                                <i class="fa fa-quote-right mr-4 text-cyan" style="font-size: 1.5rem"></i>
                                <div class="d-flex flex-column">
                                    <h5 class="m-0 text-sm">Yismen Jorge</h5>
                                    <p class="text-black-50 text-sm">Workforce Manager</p>
                                </div>
                            </div>
                            <p class="text-sm">
                                Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ea maxime dolores perferendis
                                magnam itaque, in nesciunt veritatis..
                            </p>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="p-4 rounded testimonials">
                        <div class="d-flex flex-column">
                            <div class="d-flex justify-content-start">
                                <i class="fa fa-quote-right mr-4 text-cyan" style="font-size: 1.5rem"></i>
                                <div class="d-flex flex-column">
                                    <h5 class="m-0 text-sm">Yismen Jorge</h5>
                                    <p class="text-black-50 text-sm">Workforce Manager</p>
                                </div>
                            </div>
                            <p class="text-sm">
                                Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ea maxime dolores perferendis
                                magnam itaque, in nesciunt veritatis..
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- <div class="mt-4 row" style=" row-gap: 15px; ">
                <div class="col-md-4">
                    <div class="p-4 rounded shadow" style="background-color: rgb(0 0 0 / 10%);">
                        <div class="d-flex flex-column">
                            <div class="d-flex justify-content-start">
                                <i class="fa fa-quote-right mr-4 text-{{ $color }}" style="font-size: 1.5rem"></i>
                                <div class="d-flex flex-column">
                                    <h5 class="text-bold m-0">Yismen Jorge</h5>
                                    <p>Workforce Manager</p>
                                </div>
                            </div>
                            <p class="text-black-50 font-italic">
                                Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ea maxime dolores perferendis
                                magnam itaque, in nesciunt veritatis..
                            </p>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="p-4 rounded shadow" style="background-color: rgb(0 0 0 / 10%);">
                        <div class="d-flex flex-column">
                            <div class="d-flex justify-content-start">
                                <i class="fa fa-quote-right mr-4 text-{{ $color }}" style="font-size: 1.5rem"></i>
                                <div class="d-flex flex-column">
                                    <h5 class="text-bold m-0">Yismen Jorge</h5>
                                    <p>Workforce Manager</p>
                                </div>
                            </div>
                            <p class="text-black-50 font-italic">
                                Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ea maxime dolores perferendis
                                magnam itaque, in nesciunt veritatis..
                            </p>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="p-4 rounded shadow" style="background-color: rgb(0 0 0 / 10%);">
                        <div class="d-flex flex-column">
                            <div class="d-flex justify-content-start">
                                <i class="fa fa-quote-right mr-4 text-{{ $color }}" style="font-size: 1.5rem"></i>
                                <div class="d-flex flex-column">
                                    <h5 class="text-bold m-0">Yismen Jorge</h5>
                                    <p>Workforce Manager</p>
                                </div>
                            </div>
                            <p class="text-black-50 font-italic">
                                Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ea maxime dolores perferendis
                                magnam itaque, in nesciunt veritatis..
                            </p>
                        </div>
                    </div>
                </div>


            </div> --}}
        </section>

        <section class="container py-5" id="features">
            <h3 class="text-bold text-center">Designed to boost awerness and productivity</h3>
            <p class="text-black-50 text-center">A whole lot of <span
                    class="text-bold text-{{ $color }}">Features</span> to
                make your job easier!</p>

            <div class="row mt-4" style=" row-gap: 15px; ">
                <div class="col-sm-6 col-md-4">
                    <i class="fa fa-users text-{{ $color }}" style="font-size: 2rem;"></i>
                    <h5 class="mt-3 text-bold">Human Resources</h5>
                    <p class="text-black-50">
                        Help to streamline HR processes, improve efficiency, enhance employee satisfaction, and enable
                        HR professionals to focus on strategic initiatives rather than administrative tasks.
                    </p>
                </div>

                <div class="col-sm-6 col-md-4">
                    <i class="fa fa-clock text-{{ $color }}" style="font-size: 2rem; font-weight: 300;"></i>
                    <h5 class="mt-3 text-bold">Scheduled Reports</h5>
                    <p class="text-black-50">
                        Automated reports which can be sent on the clock as designed, to fixed or dynamic distribution
                        lists.
                    </p>
                </div>

                <div class="col-sm-6 col-md-4">
                    <i class="fa fa-ticket-alt text-{{ $color }}" style="font-size: 2rem;"></i>
                    <h5 class="mt-3 text-bold">Tickets Support</h5>
                    <p class="text-black-50">Request support accross all departments, track status, receive
                        notifications on every step, rate the service, track department service levels.</p>
                </div>

                <div class="col-sm-6 col-md-4">
                    <i class="fa fa-award text-{{ $color }}" style="font-size: 2rem; "></i>
                    <h5 class="mt-3 text-bold">Quality Assurances</h5>
                    <p class="text-black-50">Notify supervisors when audit is completed, rank agents, identify areas of
                        improvement, reinforce good behaviours. Make decisions based on results. Yes, continuous
                        inprovement is possible.</p>
                </div>

                <div class="col-sm-6 col-md-4">
                    <i class="fa fa-question-circle text-{{ $color }}" style="font-size: 2rem; font-weight: 300;"></i>
                    <h5 class="mt-3 text-bold">Surveys</h5>
                    <p class="text-black-50">Gauge employees' satisfaction, identify weaknesses and assess strengths.
                        Share results in a graphical way. Your team members matter, make sure they feel it.</p>
                </div>
            </div>

            <div class="d-flex justify-content-center mt-4">
                @auth
                <a href="{{ route('home') }}" class="bg-{{ $color }} btn shadow">Visit App</a>
                @else
                <a href="{{ route('login') }}" class="bg-{{ $color }} btn shadow">Log In</a>
                @endauth
            </div>
        </section>


        <!-- Main Footer -->
        <footer class="bg-{{ $color }} mt-4" style="padding: 6rem 0;">
            <div class="container">
                <div class="row">
                    <div class="col-sm-4  mt-2 mt-sm-0">
                        <h5>Ecco Group DR</h5>
                        <div class="text-white-50 d-flex flex-column">
                            <a href="tel:+1-809-583-1171" class="text-white-50">
                                <i class="fa fa-phone"></i>
                                1-809-583-1171
                            </a>
                            <a href="mailto:info@eccocorpbpo.com" class="text-white-50">
                                <i class="fa fa-mail-bulk"></i>
                                info@eccocorpbpo.com
                            </a>
                            <div>
                                <i class="fa fa-address-card"></i> Calle Hostos #22. Los Colegios.
                            </div>
                            <div>
                                Santiago, Dominican Republic.
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-4 mt-2 mt-sm-0">

                    </div>

                    <div class="col-sm-4 mt-2 mt-sm-0">
                        <h6>Yismen Jorge</h6>
                        <div class="text-white-50 d-flex flex-column">
                            <a href="mailto:yjorge@eccocorpbpo.com" class="text-white-50">
                                <i class="fa fa-mail-bulk"></i>
                                yjorge@eccocorpbpo.com
                            </a>
                            <a href="tel:+1-829-521-3304" class="text-white-50">
                                <i class="fa fa-phone"></i>
                                1-829-521-3304
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
    </div>

    @vite('resources/js/app.js')
</body>

</html>