
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
        <button id="play-audio" class="btn btn-primary">Воспроизвести аудио</button>
        <button id="start-test" class="btn btn-primary" style="display: none;">Начать тест</button>
        <h4> | <span id="remember"> </span> <span id="timer"> </span></h4>
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
        @if($part->type == 'listening_video')
            {!! $part->video_frame !!}
        @endif
        <audio id="audio" src="{{ asset($part->audio) }}"></audio>
        <div id="test-container" style="display: none">
            <form action="{{ route('user.quiz.check') }}" method="post" id="submit-form">
                @csrf
                <input type="hidden" name="quiz_count" value="{{ count($part->questions) }}">
                <input type="hidden" name="part_id" value="{{ $part->id }}">
                <input type="hidden" name="section_id" value="{{ $part->section_id }}">
                <input type="hidden" name="exam_result_id" value="{{ session('exam_result_id') }}">
                @foreach($part->questions as $id=> $quiz)
                    <div class="small_tests">
                        <section class="small_test">
                            <div>
                                <h2 class="test_title">{{ $quiz['question'] }}</h2>
                                @foreach ($quiz['answers']->shuffle() as $item)
                                    <label>
                                        <input type="radio" name="answers[{{ $id }}]" value="{{ $item['is_correct'] }}">
                                        <span>{{ $item['answer'] }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </section>
                    </div>
                @endforeach
            </form>
        </div>
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
    var audioElement = document.getElementById("audio");
    var playButton = document.getElementById("play-audio");
    var startTestButton = document.getElementById("start-test");
    var testContainer = document.getElementById("test-container");
    var countdownElement = document.getElementById("timer");
    var rememberElement = document.getElementById("remember");

    var examDuration = 30 * 60; // 30 daqiqa (1800 soniya)

    // 1. Audio tugmasi bosilganda ijro etish
    playButton.addEventListener("click", function () {
        audioElement.play().then(() => {
            playButton.style.display = "none"; // Tugmani yashirish
            rememberElement.innerHTML = "Слушать аудио...";
            startAudioCountdown();
        }).catch(error => {
            console.error("Невозможно воспроизвести аудио:", error);
        });
    });

    // 2. Audio davomiyligi bo‘yicha hisoblash
    function startAudioCountdown() {
        var duration = Math.floor(audioElement.duration); // Audio uzunligi
        countdownElement.innerHTML = duration;
        var countdown = duration;

        var interval = setInterval(function () {
            countdown--;
            countdownElement.innerHTML = countdown;

            if (countdown <= 0) {
                clearInterval(interval);
                rememberElement.innerHTML = "Звук закончен. Тест можно начинать!";
                startTestButton.style.display = "block"; // Test tugmasini chiqarish
            }
        }, 1000);
    }

    // 3. Testni boshlash tugmasi bosilganda
    startTestButton.addEventListener("click", function () {
        startTestButton.style.display = "none"; // Tugmani yashirish
        testContainer.style.display = "block"; // Testni chiqarish
        rememberElement.innerHTML = "Время испытаний началось!";
        startExamTimer();
    });

    function startExamTimer() {
        var count = {{ $part->duration*60 }};
        var counter = setInterval(function () {
            count--;
            if (count === 0) {
                document.getElementById('submit-button').click();
            }
            document.getElementById('timer').innerHTML = formatTime(count);
        }, 1000);
    }

    function formatTime(seconds) {
        var h = Math.floor(seconds / 3600),
            m = Math.floor(seconds / 60) % 60,
            s = seconds % 60;
        if (h < 10) h = "0" + h;
        if (m < 10) m = "0" + m;
        if (s < 10) s = "0" + s;
        return h + ":" + m + ":" + s;
    }



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
