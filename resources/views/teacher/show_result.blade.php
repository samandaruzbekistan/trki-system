@extends('teacher.header')

@push('css')
    <style>
        .pagination{height:36px;margin:0;padding: 0;}
        .pager,.pagination ul{margin-left:0;*zoom:1}
        .pagination ul{padding:0;display:inline-block;*display:inline;margin-bottom:0;-webkit-border-radius:3px;-moz-border-radius:3px;border-radius:3px;-webkit-box-shadow:0 1px 2px rgba(0,0,0,.05);-moz-box-shadow:0 1px 2px rgba(0,0,0,.05);box-shadow:0 1px 2px rgba(0,0,0,.05)}
        .pagination li{display:inline}
        .pagination a{float:left;padding:0 12px;line-height:30px;text-decoration:none;border:1px solid #ddd;border-left-width:0}
        .pagination .active a,.pagination a:hover{background-color:#f5f5f5;color:#94999E}
        .pagination .active a{color:#94999E;cursor:default}
        .pagination .disabled a,.pagination .disabled a:hover,.pagination .disabled span{color:#94999E;background-color:transparent;cursor:default}
        .pagination li:first-child a,.pagination li:first-child span{border-left-width:1px;-webkit-border-radius:3px 0 0 3px;-moz-border-radius:3px 0 0 3px;border-radius:3px 0 0 3px}
        .pagination li:last-child a{-webkit-border-radius:0 3px 3px 0;-moz-border-radius:0 3px 3px 0;border-radius:0 3px 3px 0}
        .pagination-centered{text-align:center}
        .pagination-right{text-align:right}
        .pager{margin-bottom:18px;text-align:center}
        .pager:after,.pager:before{display:table;content:""}
        .pager li{display:inline}
        .pager a{display:inline-block;padding:5px 12px;background-color:#fff;border:1px solid #ddd;-webkit-border-radius:15px;-moz-border-radius:15px;border-radius:15px}
        .pager a:hover{text-decoration:none;background-color:#f5f5f5}
        .pager .next a{float:right}
        .pager .previous a{float:left}
        .pager .disabled a,.pager .disabled a:hover{color:#999;background-color:#fff;cursor:default}
        .pagination .prev.disabled span{float:left;padding:0 12px;line-height:30px;text-decoration:none;border:1px solid #ddd;border-left-width:0}
        .pagination .next.disabled span{float:left;padding:0 12px;line-height:30px;text-decoration:none;border:1px solid #ddd;border-left-width:0}
        .pagination li.active, .pagination li.disabled {
            float:left;padding:0 12px;line-height:30px;text-decoration:none;border:1px solid #ddd;border-left-width:0
        }
        .pagination li.active {
            background: #364E63;
            color: #fff;
        }
        .pagination li:first-child {
            border-left-width: 1px;
        }
    </style>
@endpush

@section('pending')
    active
@endsection
@section('section')
    <main class="content teachers">
        <div class="container-fluid p-0">
            <div class="col-12 col-xl-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h5 class="card-title mb-0">{{ $result->user->full_name }}</h5>
                    </div>
                    <div class="card-body">
                        <h4>Tekshirilgan bo'limlar:</h4>
                        <table class="table table-striped table-hover table-responsive">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Bo'lim</th>
                                <th>Foiz</th>
                                <th>Parts</th>
                            </tr>
                            </thead>
                            <tbody id="tbody">
                            @foreach($checked as $id => $section_score)
                                <tr>
                                    <td>
                                        {{ $id+1 }}
                                    </td>
                                    <td>{{ $section_score->section->name }}</td>
                                    <td>{{ $section_score->percent }}%</td>
                                    <td>
                                        @foreach($section_score->partScores as $part)
                                            <p>{{ $part->part->name }} - {{ $part->percent }}</p>
                                        @endforeach
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <br>
                        <h4>Tekshirilmagan bo'limlar:</h4>
                        <table class="table table-striped table-hover table-responsive">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Bo'lim</th>
                                <th>Partlarini tekshirish</th>
                            </tr>
                            </thead>
                            <tbody id="tbody">
                            @foreach($pending as $id => $section_score)
                                <tr>
                                    <td>
                                        {{ $id+1 }}
                                    </td>
                                    <td>{{ $section_score->section->name }}</td>
                                    <td>
                                        @foreach($section_score->partScores as $part)
                                            <p><a href="{{ route('teacher.exams.check.part', ['id' => $part->id]) }}">{{ $part->part->name }}</a></p>
                                        @endforeach
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection

