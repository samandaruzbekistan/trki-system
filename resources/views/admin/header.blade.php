
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
                <span class="align-middle">Ideal Study | NTM</span>
            </a>

            <ul class="sidebar-nav">


                <li class="sidebar-item @yield('home')">
                    <a class="sidebar-link" href="{{ route('admin.home') }}">
                        <i class="align-middle" data-feather="slack"></i>
                        <span class="align-middle">Imtixonlar</span>
                    </a>
                </li>




                <li class="sidebar-header">
                    Foydalanuvchilar
                </li>

            </ul>


        </div>
    </nav>

    <div class="main">
        <nav class="navbar navbar-expand navbar-light navbar-bg">
            <a class="sidebar-toggle js-sidebar-toggle">
                <i class="hamburger align-self-center"></i>
            </a>

            <div class="navbar-collapse collapse">
                <ul class="navbar-nav navbar-align">
                    <li class="nav-item dropdown">
                        <a class="nav-icon dropdown-toggle d-inline-block d-sm-none" href="#" data-bs-toggle="dropdown">
                            <i class="align-middle" data-feather="settings"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end">
                            <a class="dropdown-item" href="{{ route('admin.profile') }}"><i class="align-middle me-1" data-feather="user"></i> Profile</a>
                           <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="{{ route('admin.logout') }}">Chiqish</a>
                        </div>
                    </li>
                </ul>
            </div>
        </nav>

        @yield('section')

        <footer class="footer">
            <div class="container-fluid">
                <div class="row text-muted">
                    <div class="col-6 text-start">
                        <p class="mb-0">
                            <a class="text-muted" href="#" target="_blank"><strong>Ideal Study</strong></a> - <a class="text-muted" href="#" target="_blank"><strong>O'quv markazi</strong></a>								&copy;
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
