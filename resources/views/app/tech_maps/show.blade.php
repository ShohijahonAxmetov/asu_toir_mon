@extends('layouts.app')

@section('links')
@livewireStyles
@endsection

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
                            <th scope="row">Группа</th>
                            <td class="">{{$item->techMapGroup->title}}</td>
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

                        <a href="{{ route($route_parameter.'.operations.add', ['tech_map' => $item->id]) }}" class="btn btn-primary lift">
                            Редактировать
                        </a>

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
                            <th scope="col">Продолжительность</th>
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
                                            <h2 class="accordion-header" id="flush-heading{{$operation->id}}">
                                                <button class="h5 px-0 mb-0 text-start border-0 bg-transparent" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapse{{$operation->id}}" aria-expanded="false" aria-controls="flush-collapse{{$operation->id}}" style="padding-top: 1.32rem;padding-bottom: 1.32rem">
                                                    <b>Технологическая карта:</b> {{ $operation->model::find($operation->model_id)->title }}
                                                </button>
                                            </h2>
                                            <div id="flush-collapse{{$operation->id}}" class="accordion-collapse collapse show" aria-labelledby="flush-heading{{$operation->id}}">
                                                <ul class="list-group list-group-numbered">
                                                    @foreach($operation->model::find($operation->model_id)->onlyTechOperations() as $techOperation)
                                                    <li class="list-group-item">{{ $techOperation->title }} - {{$techOperation->hours.' ч '.$techOperation->minutes.' м'}}</li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </div>
                                        @endif
                                    </div>
                                </td>
                                <td class="w-100 py-0">
                                    <div class="d-flex align-items-center">
                                        @if($operation->model == 'App\Models\TechMaps\TechOperation')
                                        <span>{{$operation->hours.' ч '.$operation->minutes.' м'}}</span>
                                        @else
                                        <span>{{floor($operation->model::find($operation->model_id)->duration/60).' ч '.($operation->model::find($operation->model_id)->duration%60).' м'}}</span>
                                        @endif
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


    <!-- HEADER -->
    <div class="header">
        <div class="container-fluid">

            <!-- Body -->
            <div class="header-body">
                <div class="row align-items-end">
                    <div class="col d-flex justify-content-between">

                        <!-- Title -->
                        <h1 class="header-title">
                            Меры безопасности
                        </h1>

                        <a href="{{ route($route_parameter.'.security_measures.add', ['tech_map' => $item->id]) }}" class="btn btn-primary lift">
                            Добавить
                        </a>

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
                            <th scope="col"></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($item->securityMeasures as $securityMeasure)
                            <tr>
                                <th scope="row" style="width: 100px">{{ $loop->iteration }}</th>
                                <td>
                                    <div class="d-flex align-items-center">
                                        {{ $securityMeasure->title }}
                                    </div>
                                </td>
                                <td style="width: 200px">
                                    <div class="d-flex justify-content-end">
                                        <a class="btn btn-sm btn-danger ms-3" onclick="var result = confirm('Want to delete?');if (result){event.preventDefault();document.getElementById('delete-form-security_measures{{ $securityMeasure->pivot->id }}').submit();}"><i class="fe fe-trash"></i></a>
                                        <form action="{{ route($route_parameter.'.security_measures.destroy', [$route_parameter => $item, 'pivot_id' => $securityMeasure->pivot->id]) }}" id="delete-form-security_measures{{ $securityMeasure->pivot->id }}" method="POST" style="display: none;">
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




    <!-- HEADER -->
    <div class="header">
        <div class="container-fluid">

            <!-- Body -->
            <div class="header-body">
                <div class="row align-items-end">
                    <div class="col d-flex justify-content-between">

                        <!-- Title -->
                        <h1 class="header-title">
                            Файлы
                        </h1>

                        <a href="{{ route($route_parameter.'.tech_map_files.add', ['tech_map' => $item->id]) }}" class="btn btn-primary lift">
                            Добавить
                        </a>

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
                            <th scope="col">Файл</th>
                            <th scope="col"></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($files as $file)
                            <tr>
                                <th scope="row" style="width: 100px">{{ $loop->iteration }}</th>
                                <td>
                                    <div class="d-flex align-items-center">
                                        {{ $file->original_name }}
                                    </div>
                                </td>
                                <td>
                                    @if(in_array($file->ext, ['png','jpeg','jpg']))
                                    <img src="/storage/{{$file->name}}" height="200">
                                    @else
                                    Документ
                                    @endif
                                </td>
                                <td style="width: 200px">
                                    <div class="d-flex justify-content-end">
                                        <a href="/storage/{{$file->name}}" download="{{$file->original_name}}" class="btn btn-sm btn-info"><i class="fe fe-download"></i></a>
                                        <a class="btn btn-sm btn-danger ms-3" onclick="var result = confirm('Want to delete?');if (result){event.preventDefault();document.getElementById('delete-form-tech_map_files{{ $file->id }}').submit();}"><i class="fe fe-trash"></i></a>
                                        <form action="{{ route('files.destroy', ['file' => $file]) }}" id="delete-form-tech_map_files{{ $file->id }}" method="POST" style="display: none;">
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

@endsection

@section('scripts')
@livewireScripts
@endsection