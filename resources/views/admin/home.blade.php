@extends('admin.header')

@section('home')
    active
@endsection
@section('section')

    <main class="content forma" style="padding-bottom: 0; display: none">
        <div class="container-fluid p-0">
            <div class="col-md-8 col-xl-9">
                <div class="">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Yangi imtixon qo'shish</h5>
                        </div>
                        <div class="card-body h-100">
                            <form action="{{ route('admin.exam.create') }}" method="post">
                                @csrf
                                <div class="mb-3">
                                    <label class="form-label">Imtixon nomi <span class="text-danger">*</span></label>
                                    <input name="name" required type="text" class="form-control" placeholder="">
                                </div>
                                <div class="mb-3">
                                    <label for="levels" class="form-label">Daraja</label> <sup class="text-danger">*</sup>
                                    <select  name="level_id" required class="form-select" id="levels">
                                        <option disabled="" selected="" hidden>Tanlang</option>
                                        @foreach($levels as $level)
                                            <option value="{{ $level->id }}">{{ $level->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Sana <span class="text-danger">*</span></label>
                                    <input name="date" required type="date" min="{{ date('Y-m-d') }}" class="form-control" placeholder="">
                                </div>
                                <div class=" text-end">
                                    <button type="button" class="btn btn-danger cancel">Bekor qilish</button>
                                    <button type="submit" class="btn btn-success">Qo'shish</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>


    <main class="content exams">
        <div class="container-fluid p-0">
            <div class="row">
                <div class="col d-flex">
                    <div class="w-100">
                        <div class="d-flex justify-content-between">
                            <h3 class="mb-3">Imtixonlar</h3>
                            <button class="btn btn-primary align-middle add">Yangi imtixon</button>
                        </div>
                        <div class="row">
                            @foreach($exams as $exam)
                                <div class="col-xl-3 col-md-3">
                                    <a href="{{ route('admin.exam', ['id' => $exam->id]) }}">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col mt-0">
                                                        <h5 class="card-title">{{ $exam->level->name }}</h5>
                                                    </div>

                                                    <div class="col-auto">
                                                        <div class="stat text-primary">
                                                            <i class="align-middle text-success" data-feather="toggle-right"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                                <h1 class="mt-1 mb-3">{{ $exam->name }}</h1>
{{--                                                <div class="mb-0">--}}
{{--                                                    <span class="text-muted">Sana:</span>--}}
{{--                                                    <span class="text-danger"><i class="mdi mdi-arrow-bottom-right"></i>{{ $exam->date }}</span>--}}
{{--                                                </div>--}}
                                                <ul>
                                                    @foreach($exam->sections as $section)
                                                        <li><a href="{{ route('admin.section', ['id' => $section['id']]) }}">{{ $section['name'] }}</a></li>
                                                    @endforeach
                                                </ul>
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
        $(".add").on("click", function() {
            $('.forma').show();
            $('.exams').hide();
        });

        $(".cancel").on("click", function() {
            event.stopPropagation();
            $('.forma').hide();
            $('.exams').show();
        });
    </script>
@endsection
