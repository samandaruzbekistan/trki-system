@extends('user.header')

@section($section->type)
    active
@endsection
@section('section')
    <main class="content exams">
        <div class="container-fluid p-0">
            <div class="row">
                <div class="col d-flex">
                    <div class="w-100">
                        <div class="d-flex justify-content-between">
                            <h3 class="mb-3">{{ $section->name }}</h3>
                        </div>
                        <div class="row">
                            @foreach($section->parts as $part)
                                <div class="col-xl-3 col-md-3">
                                @if(in_array($part['id'], $solved_parts_ids))
                                    <a href="#">
                                @else
                                    <a href="{{ route('user.part.play', ['id' => $part['id']]) }}" class="confirm-link">
                                @endif
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col mt-0">
                                                        <h5 class="card-title">Время: {{ $part['duration'] }} минута</h5>
                                                    </div>

                                                    <div class="col-auto">
                                                        <div class="stat text-primary">
                                                            @if(in_array($part['id'], $solved_parts_ids))
                                                                <i class="align-middle text-success" data-feather="check"></i>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                                <h1 class="mt-1 mb-3">{{ $part->name }}</h1>
                                                @if(in_array($part['id'], $solved_parts_ids))
                                                    <span class="text-danger">завершен</span>
                                                @endif
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </main>
@endsection


@section('js')
    <script>
        $(document).ready(function () {
            $('.confirm-link').click(function (e) {
                e.preventDefault(); // Standart link ochilishini to'xtatish
                var url = $(this).attr('href'); // Linkning URL manzilini olish

                if (confirm("Вы действительно хотите начать решать эту часть?")) {
                    window.location.href = url; // Foydalanuvchi OK bosgan bo'lsa, linkga yo'naltiriladi
                }
            });
        });
    </script>
@endsection
