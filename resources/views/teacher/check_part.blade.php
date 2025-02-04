@extends('teacher.header')

@section('pending')
    active
@endsection
@section('section')
    <main class="content teachers">
        <div class="container-fluid p-0">
            <div class="col-12 col-xl-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h5 class="card-title mb-0">Partni tekshirish</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('teacher.check.part') }}" method="post">
                            @csrf
                            <input type="hidden" name="part_score_id" value="{{ $part_score_id }}">
                            @foreach($user_answers as $answer)
                                <h4>Savol: {{ $answer->question->question }}</h4>
                                @if($answer->answer != null)
                                    Javob: {{ $answer->answer }}
                                @else
                                    <audio controls>
                                        <source src="{{url($answer->audio)}}" type="audio/wav">
                                        Your browser does not support the audio element.
                                    </audio>
                                @endif
                                <div class="col-6">
                                    <label class="form-label">Ball <span class="text-danger">*</span></label>
                                    <input name="scores[{{ $answer->id }}]" required type="number" min="0" class="form-control" placeholder="">
                                </div>
                                <hr>
                            @endforeach
                            <button type="submit" class="btn btn-primary">Saqlash</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection

@section('js')
    <script>
        document.addEventListener("click", function () {
            document.querySelectorAll("audio").forEach(audio => {
                if (audio.paused) {
                    audio.play().catch(error => console.log("Audio autoplay blocklandi:", error));
                }
            });
        }, { once: true });
    </script>
@endsection
