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
                            {{ $title }}
                        </h1>

                    </div>
                    <div class="col-auto">

							<a href="{{ route($route_name . '.edit', [$route_parameter => $item]) }}" class="btn btn-primary lift">Редактировать</a>
							<a class="btn btn-danger lift ms-3" onclick="var result = confirm('Вы уверены?');if (result){event.preventDefault();document.getElementById('delete-form-main{{ $item->id }}').submit();}"> Удалить</a>
							<form action="{{ route($route_name . '.destroy', [$route_parameter => $item]) }}" id="delete-form-main{{ $item->id }}" method="POST" style="display: none;">
								@csrf
								@method('DELETE')
							</form>
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
                'url' => route($route_name.'.index'),
                'name' => $title,
                'disabled' => false
                ],
                [
                'active' => true,
                'url' => '',
                'name' => 'Просмотр',
                'disabled' => true
                ],
            ]
            ])
        <div class="card mw-50">
            <div class="card-body">
                <table class="table table-bordered table-striped">
                    <tbody>
                        <tr>
                            <th scope="row">Техническая карта</th>
                            <td class="">{{$item->techMap->title}}</td>
                        </tr>
                        <tr>
                            <th scope="row">Время начало ремонта</th>
                            <td class="">{{$item->started_at}}</td>
                        </tr>
                        <tr>
                            <th scope="row">Время конца ремонта</th>
                            <td class="">{{$item->ended_at ?? '-'}}</td>
                        </tr>
                        <tr>
                            <th scope="row">Отклонения от норматива</th>
                            @if(is_string($deviations))
                            <td class="">-</td>
                            @else
                            <td class="text-warning">{{($deviations->invert ? '-' : '+').$deviations->h.' ч '.$deviations->i.' м'}}</td>
                            @endif
                        </tr>
                        <tr>
                            <th scope="row">Комментарии</th>
                            <td class="">{{$item->comments}}</td>
                        </tr>
                        <tr>
                            <th scope="row">Дата добавления</th>
                            <td class="">{{ isset($item->created_at) ? date('d-m-Y', strtotime($item->created_at)) : '--' }}</td>
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
                            Процесс ремонта
                        </h1>

                        <!-- <a href="{{ route($route_parameter.'.logs.add', ['repair' => $item->id]) }}" class="btn btn-primary lift">
                            Добавить
                        </a> -->

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
                            <th scope="col">Наименование</th>
                            <th scope="col">Нормативное время</th>
                            <th scope="col">Время работы</th>
                            <th scope="col">Отклонения от норматива</th>
                            <th scope="col">Комментарии</th>
                            <th scope="col"></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($item->repairLogs as $log)
                            <tr>
                                <th scope="row" style="width: 100px">{{ $loop->iteration }}</th>
                                <td>
                                    <div class="d-flex align-items-center">
                                        {{ $log->techOperation->title.' ('.$log->techOperation->techOperationStage->title.')' }}
                                    </div>
                                </td>
                                <td>{{$log->techOperation->hours.' ч '.$log->techOperation->minutes.' м'}}</td>
                                <td>{{$log->duration_hours.' ч '.$log->duration_minutes.' м'}}</td>
                                <td class="{{$log->deviation() != '-' ? 'bg-warning' : ''}}">{{$log->deviation()}}</td>
                                <td>{{$log->comments ?? '-'}}</td>
                                <td style="width: 200px">
                                    <div class="d-flex justify-content-end">
                                        <a href="{{ route($route_parameter.'.logs.edit', [$route_parameter => $item, 'pivot_id' => $log->id]) }}" class="btn btn-sm btn-success"><i class="fe fe-edit-2"></i></a>
                                        <a class="btn btn-sm btn-danger ms-3" onclick="var result = confirm('Want to delete?');if (result){event.preventDefault();document.getElementById('delete-form-tech_resource{{ $log->id }}').submit();}"><i class="fe fe-trash"></i></a>
                                        <form action="{{ route($route_parameter.'.logs.destroy', [$route_parameter => $item, 'pivot_id' => $log->id]) }}" id="delete-form-tech_resource{{ $log->id }}" method="POST" style="display: none;">
                                            @csrf
                                            @method('DELETE')
                                        </form>
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

    <!-- Card -->
    <div class="card">
        <div class="card-body">
            <!-- Button -->
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalMembers"> Launch demo modal </button>
        </div>
    </div>

    <!-- MODALS -->
    <!-- Modal: Members -->
    <div class="modal fade" id="modalMembers" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="card mb-0" data-list='{"valueNames": ["name"]}'>
                    <div class="card-header">
                        <!-- Title -->
                        <h4 class="card-header-title" id="exampleModalCenterTitle"> Редактирование процесса </h4>
                        <!-- Close -->
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="card-body">
                        <p>Продолжительность работы</p>
                        <div class="row">
                            <div class="col-6">
                                <label for="title" class="form-label required">Часы</label>
                                <input type="text" class="form-control @error('hours') is-invalid @enderror" name="hours" value="{{ old('hours', 1) }}" id="hours" placeholder="Часы..." required>
                                @error('hours')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="col-6">
                                <label for="unit_id" class="form-label required">Минуты</label>
                                <input type="text" class="form-control @error('minutes') is-invalid @enderror" name="minutes" value="{{ old('minutes', 1) }}" id="minutes" placeholder="Часы..." required>
                                @error('minutes')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div><br>
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="characteristics" class="form-label">Комментарии</label>
                                    <textarea rows="5" class="form-control @error('characteristics') is-invalid @enderror" name="characteristics" id="characteristics" placeholder="Комментарии...">{{ old('characteristics') }}</textarea>
                                    @error('characteristics')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>                                    
                            </div>
                        </div>
                        <!-- Button -->
                        <div class="model-btns d-flex justify-content-end">
                            <a type="button" class="btn btn-secondary">Отмена</a>
                            <input type="submit" name="action" value="Сохранить" class="btn btn-success ms-2" />
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
