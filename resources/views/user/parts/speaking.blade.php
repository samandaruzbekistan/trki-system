
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
    <link href="{{ asset('css/quiz.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
</head>

<body>
<div class="main">
    <nav class="navbar navbar-expand navbar-light navbar-bg mb-5 fixed-top">

        <h4>Экзамен: {{ session('exam_name') }}  </h4>
        <h4> | Оставшееся время: <span id="timer">0</span></h4>
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
                        <a class="dropdown-item" href="{{ route('admin.logout') }}">Chiqish</a>
                    </div>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container ps-5 pt-5 mt-5 pe-5">
        <h2>{{ $part->name }}</h2>
        <h3>{!! $part->description !!}</h3>
        <form action="{{ route('user.speaking.check') }}" method="post" id="submit-form">
            @csrf
            <input type="hidden" name="quiz_count" value="{{ count($part->questions) }}">
            <input type="hidden" name="part_id" value="{{ $part->id }}">
            <input type="hidden" name="section_id" value="{{ $part->section_id }}">
            <input type="hidden" name="exam_result_id" value="{{ session('exam_result_id') }}">
            @foreach($part->questions as $id=> $quiz)
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">{{ $quiz->question }}</h5>
                    </div>
                    <input type="hidden" name="question_id[]" value="{{ $quiz->id }}">
                    <button type="button" class="btn btn-primary record-btn" data-id="{{ $quiz->id }}">
                        🎙 Ovoz yozish
                    </button>
                    <audio class="audio-preview d-none" controls></audio>
                    <input type="hidden" name="audio_{{ $quiz->id }}" class="audio-input">
                </div>
            @endforeach
            <br><br>
            <br><br>
        </form>
    </div>

    <footer class="footer fixed-bottom">
        <div class="container-fluid">
            <div class="row text-muted">
                <div class="col-6 text-start">
                    <p class="mb-0">
                    </p>
                </div>
                <div class="col-6 text-end">
                    <ul class="list-inline">
                        <li class="list-inline-item">
                            <button id="submit-button" class="btn btn-danger btn-lg" style="text-align: center !important;">Oтправить</button>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </footer>
</div>
</body>

<script src="{{ asset('js/app.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js" integrity="sha512-3gJwYpMe3QewGELv8k/BX9vcqhryRdzRMxVfq6ngyWXwo03GFEzjsUm8Q7RZcHPHksttq7/GFoxjCVUjkjvPdw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script>
    let mediaRecorder;
    let audioChunks = {};

    document.querySelectorAll(".record-btn").forEach(button => {
        button.addEventListener("click", async function () {
            let questionId = this.getAttribute("data-id");
            let audioPreview = this.nextElementSibling;
            let audioInput = this.nextElementSibling.nextElementSibling;

            if (!mediaRecorder || mediaRecorder.state === "inactive") {
                // Ovoz yozishni boshlash
                let stream = await navigator.mediaDevices.getUserMedia({ audio: true });
                mediaRecorder = new MediaRecorder(stream);
                audioChunks[questionId] = [];

                mediaRecorder.ondataavailable = event => {
                    audioChunks[questionId].push(event.data);
                };

                mediaRecorder.onstop = () => {
                    let audioBlob = new Blob(audioChunks[questionId], { type: "audio/wav" });
                    let audioUrl = URL.createObjectURL(audioBlob);
                    audioPreview.src = audioUrl;
                    audioPreview.classList.remove("d-none");

                    // Audio faylni bazaga jo'natish uchun `base64` yoki blob
                    let reader = new FileReader();
                    reader.readAsDataURL(audioBlob);
                    reader.onloadend = function () {
                        audioInput.value = reader.result;
                    };
                };

                mediaRecorder.start();
                this.textContent = "🛑 Yozishni to'xtatish";
            } else {
                // Ovoz yozishni to'xtatish
                mediaRecorder.stop();
                this.textContent = "🎙 Ovoz yozish";
            }
        });
    });
</script>


<script>
    function formatTime(seconds) {
        var h = Math.floor(seconds / 3600),
            m = Math.floor(seconds / 60) % 60,
            s = seconds % 60;
        if (h < 10) h = "0" + h;
        if (m < 10) m = "0" + m;
        if (s < 10) s = "0" + s;
        return h + ":" + m + ":" + s;
    }

    var count = {{ $part->duration*60 }};
    var counter = setInterval(timer, 1000);

    function timer() {
        count--;
        if (count === 0) {
            document.getElementById('submit-button').click();
        }
        document.getElementById('timer').innerHTML = formatTime(count);
    }
</script>

<script>
    $("#submit-button").on("click", function () {
        $('#submit-form').trigger("submit");
    });

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
