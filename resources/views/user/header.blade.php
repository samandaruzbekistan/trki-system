
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link rel="shortcut icon" href="{{ asset('img/icons/icon-48x48.png') }}" />


    @stack('css')
    <title>Admin | Ideal Study</title>

    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
</head>

<body>
<div class="wrapper">
    <nav id="sidebar" class="sidebar js-sidebar">
        <div class="sidebar-content js-simplebar">
            <a class="sidebar-brand" href="/admin/home">
                <span class="align-middle">Ideal Study | ITRK</span>
            </a>

            <ul class="sidebar-nav">


                <li class="sidebar-item @yield('home')">
                    <a class="sidebar-link" href="{{ route('admin.home') }}">
                        <i class="align-middle" data-feather="check-square"></i>
                        <span class="align-middle">Лексика. Грамматика</span>
                    </a>
                </li>

                @if($exam_result->reading_score == null)
                    <li class="sidebar-item @yield('reading')">
                        <a class="sidebar-link" href="{{ route('admin.home') }}">
                            <i class="align-middle" data-feather="lock"></i>
                            <span class="align-middle">Чтение</span>
                        </a>
                    </li>
                @else
                    <li class="sidebar-item @yield('reading')">
                        <a class="sidebar-link" href="{{ route('admin.home') }}">
                            <i class="align-middle" data-feather="check-square"></i>
                            <span class="align-middle">Чтение</span>
                        </a>
                    </li>
                @endif

                @if($exam_result->listening_score == null)
                    <li class="sidebar-item @yield('reading')">
                        <a class="sidebar-link" href="{{ route('admin.home') }}">
                            <i class="align-middle" data-feather="lock"></i>
                            <span class="align-middle">Аудирование</span>
                        </a>
                    </li>
                @else
                    <li class="sidebar-item @yield('reading')">
                        <a class="sidebar-link" href="{{ route('admin.home') }}">
                            <i class="align-middle" data-feather="check-square"></i>
                            <span class="align-middle">Аудирование</span>
                        </a>
                    </li>
                @endif

                @if($exam_result->writing_score == null)
                    <li class="sidebar-item @yield('reading')">
                        <a class="sidebar-link" href="{{ route('admin.home') }}">
                            <i class="align-middle" data-feather="lock"></i>
                            <span class="align-middle">Письмо</span>
                        </a>
                    </li>
                @else
                    <li class="sidebar-item @yield('reading')">
                        <a class="sidebar-link" href="{{ route('admin.home') }}">
                            <i class="align-middle" data-feather="check-square"></i>
                            <span class="align-middle">Письмо</span>
                        </a>
                    </li>
                @endif

                @if($exam_result->speaking_score == null)
                    <li class="sidebar-item @yield('reading')">
                        <a class="sidebar-link" href="{{ route('admin.home') }}">
                            <i class="align-middle" data-feather="lock"></i>
                            <span class="align-middle">Говорение</span>
                        </a>
                    </li>
                @else
                    <li class="sidebar-item @yield('reading')">
                        <a class="sidebar-link" href="{{ route('admin.home') }}">
                            <i class="align-middle" data-feather="check-square"></i>
                            <span class="align-middle">Говорение</span>
                        </a>
                    </li>
                @endif


            </ul>


        </div>
    </nav>

    <div class="main">
        <nav class="navbar navbar-expand navbar-light navbar-bg">
            <a class="sidebar-toggle js-sidebar-toggle">
                <i class="hamburger align-self-center"></i>
            </a>
            <h4>Экзамен: {{ session('exam_name') }}</h4>
            <div class="navbar-collapse collapse">
                <ul class="navbar-nav navbar-align">

                    <li class="nav-item">
                        <a class="nav-icon d-none d-lg-block" href="#" id="fullscreenLink">
                            <div class="position-relative">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-maximize align-middle"><path d="M8 3H5a2 2 0 0 0-2 2v3m18 0V5a2 2 0 0 0-2-2h-3m0 18h3a2 2 0 0 0 2-2v-3M3 16v3a2 2 0 0 0 2 2h3"></path></svg>
                            </div>
                        </a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-icon dropdown-toggle d-inline-block d-sm-none" href="#" data-bs-toggle="dropdown">
                            <i class="align-middle" data-feather="settings"></i>
                        </a>

                        <a class="nav-link dropdown-toggle d-none d-sm-inline-block" href="#" data-bs-toggle="dropdown">
                            {{ session('name') }}
                        </a>
                        <div class="dropdown-menu dropdown-menu-end">
                            <a class="dropdown-item" href=""><i class="align-middle me-1" data-feather="user"></i> Profile</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="{{ route('user.logout') }}">Chiqish</a>
                        </div>
                    </li>
                </ul>
            </div>
        </nav>

        <div class="h-100" id="search-section" style="display: none">

        </div>

        @yield('section')

        <footer class="footer">
            <div class="container-fluid">
                <div class="row text-muted">
                    <div class="col-6 text-start">
                        <p class="mb-0">
                            <a class="text-muted" href="#" target="_blank"><strong>Ideal Study</strong></a> - <a class="text-muted" href="#" target="_blank"><strong>Xususiy maktabi</strong></a>								&copy;
                        </p>
                    </div>
                    <div class="col-6 text-end">
                        <ul class="list-inline">
                            <li class="list-inline-item">
                                <a class="text-muted" href="https://t.me/Samandar_developer" target="_blank">Dasturchi: <span class="text-primary">Samandar Sariboyev</span></a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </footer>
    </div>
</div>

<script src="{{ asset('js/app.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js" integrity="sha512-3gJwYpMe3QewGELv8k/BX9vcqhryRdzRMxVfq6ngyWXwo03GFEzjsUm8Q7RZcHPHksttq7/GFoxjCVUjkjvPdw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
@yield('js')
<script>
    @if($errors->any())
        const notyf = new Notyf();
        @foreach ($errors->all() as $error)
            notyf.error({
                message: '{{ $error }}',
                duration: 7000,
                dismissible: true,
                position: {
                    x : 'right',
                    y : 'bottom'
                },
            });
        @endforeach
    @endif

    @if(session('failed'))
        const notyf = new Notyf();

        notyf.error({
            message: '{{ session('failed') }}',
            duration: 7000,
            dismissible : true,
            position: {
                x : 'right',
                y : 'bottom'
            },
        });
    @endif

    @if(session('successfully'))
        const notyf = new Notyf();

        notyf.success({
            message: '{{ session('successfully') }}',
            duration: 7000,
            dismissible : true,
            position: {
                x : 'right',
                y : 'bottom'
            },
        });
    @endif
</script>
<div class="notyf" style="justify-content: flex-start; align-items: center;"></div>
<div class="notyf-announcer" aria-atomic="true" aria-live="polite" style="border: 0px; clip: rect(0px, 0px, 0px, 0px); height: 1px; margin: -1px; overflow: hidden; padding: 0px; position: absolute; width: 1px; outline: 0px;">Inconceivable!</div>
</body>

</html>
