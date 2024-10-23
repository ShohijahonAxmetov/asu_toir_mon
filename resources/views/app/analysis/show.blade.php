@extends('layouts.app')

@section('content')
    <!-- HEADER -->
    <div class="header">
        <div class="container-fluid">

            <!-- Body -->
            <div class="header-body">
                <div class="row align-items-end">
                    <div class="col">

                        <!-- Title -->
                        <h1 class="header-title">
                            Анализ техкарты {{$item->code}}
                        </h1>

                    </div>
                </div> <!-- / .row -->
            </div> <!-- / .header-body -->
        </div>
    </div> <!-- / .header -->

    <!-- CARDS -->
    <div class="container-fluid">
    @include('app.components.breadcrumb', [
            'datas' => [
                [
                'active' => false,
                'url' => route('analysis.index'),
                'name' => 'Анализ',
                'disabled' => false
                ],
                [
                'active' => true,
                'url' => '',
                'name' => 'Анализ техкарты '.$item->code,
                'disabled' => true
                ],
            ]
            ])
        <div class="card mw-50">
            <div class="card-body">
                <table class="table table-bordered table-striped">
                    <tbody>
                        <tr>
                            <th scope="row">Группа</th>
                            <td class="">{{$item->techMapGroup->title ?? '-'}}</td>
                        </tr>
                        <tr>
                            <th scope="row">Наименование</th>
                            <td class="">{{$item->title}}</td>
                        </tr>
                        <tr>
                            <th scope="row">Код</th>
                            <td class="">{{$item->code}}</td>
                        </tr>
                        <tr>
                            <th scope="row">Плановые затраты</th>
                            <td class="">{{number_format($item->amount)}} сум</td>
                        </tr>
                        <tr>
                            <th scope="row">Фактические затраты</th>
                            <td class="{{$item->amount != $item->avg_amount ? 'bg-warning' : ''}}">{{number_format($item->avg_amount)}} сум</td>
                        </tr>
                        <tr>
                            <th scope="row">Продолжительность</th>
                            <td class="">{{$item->hours.' ч '.$item->minutes.' мин'}}</td>
                        </tr>
                        <tr>
                            <th scope="row">Комментарии</th>
                            <td class="">{{ $item->comments}}</td>
                        </tr>
                        <tr>
                            <th scope="row">Действующий документ</th>
                            <td class="">{{$item->agreed_at ? '✅' : '🔄'}}</td>
                        </tr>
                        <tr>
                            <th scope="row">Дата согласования</th>
                            <td class="">{{$item->agreed_at ? date('d-m-Y', strtotime($item->agreed_at)) : '-'}}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>



    <!-- HEADER -->
    <div class="header">
        <div class="container-fluid">

            <!-- Body -->
            <div class="header-body">
                <div class="row align-items-end">
                    <div class="col d-flex justify-content-between">

                        <!-- Title -->
                        <h1 class="header-title">
                            Операции
                        </h1>

                    </div>
                </div> <!-- / .row -->
            </div> <!-- / .header-body -->
        </div>
    </div> <!-- / .header -->

    <!-- CARDS -->
    <div class="container-fluid">
        <div class="card mt-4">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-sm table-hover mb-0">
                        <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Заголовок</th>
                            <th scope="col">Норматив продолжительности</th>
                            <th scope="col">Средняя время продолжительности</th>
                            <th scope="col"></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($tech_map_operations as $operation)
                            <tr>
                                <th scope="row" style="width: 100px">{{ $loop->iteration }}</th>
                                <td class="w-100 py-0">
                                    <div class="d-flex align-items-center">
                                        @if($operation->model == 'App\Models\TechMaps\TechOperation')
                                        <span>{{$operation->title}}</span>
                                        @else
                                        <div class="accordion-item w-100 border-0 bg-transparent">
                                            <h2 class="accordion-header" id="flush-headingOne">
                                                <button class="accordion-button px-0 border-0 bg-transparent" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapse{{$operation->id}}" aria-expanded="false" aria-controls="flush-collapse{{$operation->id}}">
                                                    Технологическая карта: {{ $operation->model::find($operation->model_id)->title }}
                                                </button>
                                            </h2>
                                            <div id="flush-collapse{{$operation->id}}" class="accordion-collapse collapse show" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                                                <ul class="list-group">
                                                    @foreach($operation->model::find($operation->model_id)->onlyTechOperations() as $techOperation)
                                                    <li class="list-group-item">{{ $techOperation->title }}</li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </div>
                                        @endif
                                    </div>
                                </td>
                                <td class="w-100 py-0">
                                    <div class="d-flex align-items-center">
                                        <span>{{$operation->hours.' ч '.$operation->minutes.' м'}}</span>
                                    </div>
                                </td>
                                <td class="w-100 py-0 {{($operation->hours*60 + $operation->minutes) != $operation->avg_duration ? 'bg-warning' : ''}}">
                                    <div class="d-flex align-items-center">
                                        <span>{{floor($operation->avg_duration/60).' ч '.round(($operation->avg_duration/60 - floor($operation->avg_duration/60))*60).' м'}}</span>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection
