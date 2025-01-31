@extends('admin.header')
@push('css')
    <link href="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.snow.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/highlight.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.js"></script>
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/styles/atom-one-dark.min.css"
    />
    <script src="https://cdn.jsdelivr.net/npm/katex@0.16.9/dist/katex.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/katex@0.16.9/dist/katex.min.css" />
@endpush

@section('olympic_exam_days')
    active
@endsection
@section('section')
    <div class="container-fluid ps-5 pt-4 pe-5">
        <div class="row mb-2 mb-xl-3">
            <div class="col-auto d-none d-sm-block">
                <h3><strong>{{ $section->name }}</strong> bo'limlari</h3>
            </div>
            <div class="col-auto ms-auto text-end mt-n1">
                <a href="#" class="btn btn-primary add-section">+ Yangi bo'lim</a>
            </div>
        </div>
        <div class="col-md-8 col-xl-9 new-section" style="display:none;">
            <div class="">
                <div class="card">
                    <div class="card-body h-100">
                        <form action="{{ route('admin.part.create') }}" method="post" enctype="multipart/form-data" id="new-part">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label">Nomi <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="name">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Matn <span class="text-danger">*</span></label>
                                <div id="toolbar-container">
                                       <span class="ql-formats">
                                       <select class="ql-font"></select>
                                       <select class="ql-size"></select>
                                       </span>
                                    <span class="ql-formats">
                                       <button class="ql-bold"></button>
                                       <button class="ql-italic"></button>
                                       <button class="ql-underline"></button>
                                       <button class="ql-strike"></button>
                                       </span>
                                    <span class="ql-formats">
                                       <select class="ql-color"></select>
                                       <select class="ql-background"></select>
                                       </span>
                                    <span class="ql-formats">
                                       <button class="ql-script" value="sub"></button>
                                       <button class="ql-script" value="super"></button>
                                       </span>
                                    <span class="ql-formats">
                                       <button class="ql-header" value="1"></button>
                                       <button class="ql-header" value="2"></button>
                                       <button class="ql-blockquote"></button>
                                       <button class="ql-code-block"></button>
                                       </span>
                                    <span class="ql-formats">
                                       <button class="ql-list" value="ordered"></button>
                                       <button class="ql-list" value="bullet"></button>
                                       <button class="ql-indent" value="-1"></button>
                                       <button class="ql-indent" value="+1"></button>
                                       </span>
                                    <span class="ql-formats">
                                       <button class="ql-direction" value="rtl"></button>
                                       <select class="ql-align"></select>
                                       </span>
                                    <span class="ql-formats">
                                       <button class="ql-link"></button>
                                       <button class="ql-image"></button>
                                       <button class="ql-video"></button>
                                       <button class="ql-formula"></button>
                                       </span>
                                    <span class="ql-formats">
                                               <button class="ql-clean"></button>
                                   </span>
                                </div>
                                <div id="editor">
                                </div>
                                <!-- Hidden input to store editor content -->
                                <input type="hidden" name="description" id="body-content">
                            </div>
                            <input type="hidden" name="section_id" value="{{ $section->id }}">
                            <input type="hidden" name="exam_id" value="{{ $section->exam_id }}">
                            <div class="mb-3">
                                <label class="form-label">Vaqt (minut)<span class="text-danger">*</span></label>
                                <input type="number" class="form-control" name="duration">
                            </div>
                            <div class="mb-3">
                                <label for="region" class="form-label">Turi</label> <sup class="text-danger">*</sup>
                                <select id="region" required="" class="form-select" name="type">
                                    <option disabled="" selected="" hidden>Tanlang</option>
                                    <option value="quiz">Test</option>
                                    <option value="writing">Yozma</option>
                                    <option value="speaking">So'zlashuv</option>
                                    <option value="listening_audio">Audio</option>
                                    <option value="listening_video">Video</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Audio </label>
                                <input class="form-control" name="audio" type="file" accept="audio/*">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">YouTube video frame <span class="text-danger">*</span></label>
                                <textarea name="video_frame" id="description"  rows="3" class="form-control"></textarea>
                            </div>

                            <div class=" text-end">
                                <button type="button" class="btn btn-danger section-cancel">Bekor qilish</button>
                                <button type="submit" class="btn btn-success">Qo'shish</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @foreach($section->parts as $part)
        <main class="content quizzes">
            <div class="container-fluid p-0">
                <div class="col-12 col-xl-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-6">
                                    <h5 class="card-title mb-0"><span class="text-danger">{{ $section->name }}</span>
                                        bo'limi savollari
                                    </h5>
                                </div>
                                <div class="col-6 text-end">
                                    <form action="" method="post"
                                          class="d-inline">
                                        @csrf
                                        <input type="hidden" name="section_id" value="{{ $section->id }}">
                                        <button type="submit" class="btn btn-danger">Bo'limni o'chirish</button>
                                    </form>
                                    <button class="btn btn-info add" id="{{ $section->id }}">+ Savol qo'shish</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </main>
    @endforeach

@endsection

@section('js')
    <script>
        const quill = new Quill('#editor', {
            modules: {
                syntax: true,
                toolbar: '#toolbar-container',
            },
            placeholder: 'Matn...',
            theme: 'snow',
        });

        // Handle form submission
        $('#new-part').on('submit', function (e) {
            // Get the editor content as HTML
            var editorContent = quill.root.innerHTML;

            // Update the hidden input with the editor content
            $('#body-content').val(editorContent);
        });
    </script>

    <script>
        $(".add-section").on("click", function () {
            $('.new-section').show();
            $('.quizzes').hide();
        });

        $(".section-cancel").on("click", function () {
            event.stopPropagation();
            $('.new-section').hide();
            $('.quizzes').show();
        });

        $(".add").on("click", function () {
            let sectionID = $(this).attr('id');
            $('#section_id').val(sectionID);
            $('.forma').show();
            $('.quizzes').hide();
        });

        $(".cancel").on("click", function () {
            event.stopPropagation();
            $('.forma').hide();
            $('.quizzes').show();
        });

        $(".cancel1").on("click", function () {
            event.stopPropagation();
            $('.edit-forma').hide();
            $('.quizzes').show();
        });

        @if($errors->any())
        const notyf = new Notyf();

        @foreach ($errors->all() as $error)
        notyf.error({
            message: '{{ $error }}',
            duration: 5000,
            dismissible: true,
            position: {
                x: 'center',
                y: 'top'
            },
        });
        @endforeach

        @endif


        @if(session('success') == 1)
        const notyf = new Notyf();

        notyf.success({
            message: 'Imtixon kuni qo\'shildi!',
            duration: 5000,
            dismissible: true,
            position: {
                x: 'right',
                y: 'bottom'
            },
        });
        @endif

        @if(session('new-section') == 1)
        const notyf = new Notyf();

        notyf.success({
            message: 'Savollar bo\'limi qo\'shildi!',
            duration: 5000,
            dismissible: true,
            position: {
                x: 'right',
                y: 'bottom'
            },
        });
        @endif

        @if(session('section_delete') == 1)
        const notyf = new Notyf();

        notyf.success({
            message: 'Savollar bo\'limi o\'chirildi!',
            duration: 5000,
            dismissible: true,
            position: {
                x: 'right',
                y: 'bottom'
            },
        });
        @endif

        @if(session('quiz_save') == 1)
        const notyf = new Notyf();

        notyf.success({
            message: 'Savol  qo\'shildi!',
            duration: 5000,
            dismissible: true,
            position: {
                x: 'right',
                y: 'bottom'
            },
        });
        @endif


        @if(session('error') == 1)
        const notyf = new Notyf();

        notyf.error({
            message: 'Xatolik! Savol q\'shilmadi',
            duration: 5000,
            dismissible: true,
            position: {
                x: 'right',
                y: 'bottom'
            },
        });
        @endif

    </script>
@endsection
