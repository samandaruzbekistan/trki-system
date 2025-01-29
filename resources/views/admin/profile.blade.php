@extends('admin.header')

@section('profile')
    active
@endsection
@section('section')
    <main class="content">
        <div class="container-fluid p-0">

            <div class="mb-3">
                <h1 class="h3 d-inline align-middle">Profile</h1>

            </div>
            <div class="row">
                <div class="col-md-4 col-xl-3">
                    <div class="card mb-3">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Profil malumotlari</h5>
                        </div>
                        <div class="card-body text-center">
                            <h5 class="card-title mb-0">{{ $user->name }}</h5>
                            <div class="text-muted mb-2">Direktor</div>

                            <div>
                                <a class="btn btn-primary btn-sm" href="#">Follow</a>
                                <a class="btn btn-primary btn-sm" href="#">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                         fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                         stroke-linejoin="round" class="feather feather-message-square">
                                        <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
                                    </svg>
                                    Message</a>
                            </div>
                        </div>
                        <hr class="my-0">

                        <hr class="my-0">
                        <div class="card-body">
                            <h5 class="h6 card-title">About</h5>
                            <ul class="list-unstyled mb-0">
                                <li class="mb-1">
                                    <i class="align-middle me-1" data-feather="user"></i>F.I.SH: <a
                                        href="#">{{ $user->name }}</a>
                                </li>
                            </ul>
                        </div>
                        <hr class="my-0">
                    </div>
                </div>
                <div class="col-md-8 col-xl-9">
                    <div class="">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Parolni yangilash</h5>
                            </div>
                            <div class="card-body h-100">
                                <form action="{{ route('admin.update') }}" method="post">
                                    @csrf
                                    <div class="mb-3">
                                        <label class="form-label">Yangi parol</label>
                                        <input required name="password1" type="password" class="form-control"
                                               placeholder="">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Yangi parolni takrorlang</label>
                                        <input required name="password2" type="password" class="form-control"
                                               placeholder="">
                                    </div>
                                    <div class=" text-end">
                                        <button type="submit" class="btn btn-primary">Yangilash</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection


@section('js')
    <script>
        @if(session('password_error') == 1)
        const notyf = new Notyf();

        notyf.error({
            message: 'Parollar bir xil emas!',
            duration: 5000,
            dismissible: true,
            position: {
                x: 'center',
                y: 'top'
            },
        });
        @endif

        @if(session('success') == 1)
        const notyf = new Notyf();

        notyf.success({
            message: 'Parol muvaffaqiyatli yangilandi!',
            duration: 5000,
            dismissible: true,
            position: {
                x: 'center',
                y: 'top'
            },
        });
        @endif

        @if(session('success_photo') == 1)
        const notyf = new Notyf();

        notyf.success({
            message: 'Profil rasmi muvaffaqiyatli yangilandi!',
            duration: 5000,
            dismissible: true,
            position: {
                x: 'center',
                y: 'top'
            },
        });
        @endif
    </script>
@endsection
