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
                            <th scope="row">Этап</th>
                            <td class="">{{$item->techOperationStage->title}}</td>
                        </tr>
                        <tr>
                            <th scope="row">Наименование</th>
                            <td class="">{{$item->title}}</td>
                        </tr>
                        <tr>
                            <th scope="row">Наименование полное</th>
                            <td class="">{{$item->full_title ?? '-'}}</td>
                        </tr>
                        <tr>
                            <th scope="row">Продолжительность</th>
                            <td class="">{{$item->hours.' ч '.$item->minutes.' мин'}}</td>
                        </tr>
                        <tr>
                            <th scope="row">Расценка, сум</th>
                            <td class="">{{ number_format($item->amount)}}</td>
                        </tr>
                        <tr>
                            <th scope="row">Содержание работ</th>
                            <td class="">{{ $item->content}}</td>
                        </tr>
                        <tr>
                            <th scope="row">Комментарии</th>
                            <td class="">{{ $item->comments}}</td>
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
                            Материальные затраты
                        </h1>

                        <a href="{{ route($route_parameter.'.tech_resources.add', ['tech_operation' => $item->id]) }}" class="btn btn-primary lift">
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
                            <th scope="col">Кол-во</th>
                            <th scope="col">Ед. изм.</th>
                            <th scope="col">Характеристика</th>
                            <th scope="col"></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($item->technicalResources as $technicalResource)
                            <tr>
                                <th scope="row" style="width: 100px">{{ $loop->iteration }}</th>
                                <td>
                                    <div class="d-flex align-items-center">
                                        {{ $technicalResource->catalog_name }}
                                    </div>
                                </td>
                                <td>{{$technicalResource->pivot->quantity}}</td>
                                <td>{{\App\Models\Unit::findOrFail($technicalResource->pivot->unit_id)->name}}</td>
                                <td>{{$technicalResource->pivot->characteristics ?? '-'}}</td>
                                <td style="width: 200px">
                                    <div class="d-flex justify-content-end">
                                        <a href="{{ route($route_parameter.'.tech_resources.edit', [$route_parameter => $item, 'pivot_id' => $technicalResource->pivot->id]) }}" class="btn btn-sm btn-success"><i class="fe fe-edit-2"></i></a>
                                        <a class="btn btn-sm btn-danger ms-3" onclick="var result = confirm('Want to delete?');if (result){event.preventDefault();document.getElementById('delete-form-tech_resource{{ $technicalResource->pivot->id }}').submit();}"><i class="fe fe-trash"></i></a>
                                        <form action="{{ route($route_parameter.'.tech_resources.destroy', [$route_parameter => $item, 'pivot_id' => $technicalResource->pivot->id]) }}" id="delete-form-tech_resource{{ $technicalResource->pivot->id }}" method="POST" style="display: none;">
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
                            Трудовые затраты
                        </h1>

                        <a href="{{ route($route_parameter.'.qualifications.add', ['tech_operation' => $item->id]) }}" class="btn btn-primary lift">
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
                            <th scope="col">Квалификация</th>
                            <th scope="col">Кол-во</th>
                            <th scope="col">Время работы</th>
                            <th scope="col">Характеристика</th>
                            <th scope="col"></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($item->qualifications as $qualification)
                            <tr>
                                <th scope="row" style="width: 100px">{{ $loop->iteration }}</th>
                                <td>
                                    <div class="d-flex align-items-center">
                                        {{ $qualification->title }}
                                    </div>
                                </td>
                                <td>{{$qualification->pivot->count}}</td>
                                <td>{{$qualification->pivot->hours.' ч '.$qualification->pivot->minutes.' м'}}</td>
                                <td>{{$qualification->pivot->characteristics ?? '-'}}</td>
                                <td style="width: 200px">
                                    <div class="d-flex justify-content-end">
                                        <a href="{{ route($route_parameter.'.qualifications.edit', [$route_parameter => $item, 'pivot_id' => $qualification->pivot->id]) }}" class="btn btn-sm btn-success"><i class="fe fe-edit-2"></i></a>
                                        <a class="btn btn-sm btn-danger ms-3" onclick="var result = confirm('Want to delete?');if (result){event.preventDefault();document.getElementById('delete-form-qualification{{ $qualification->pivot->id }}').submit();}"><i class="fe fe-trash"></i></a>
                                        <form action="{{ route($route_parameter.'.qualifications.destroy', [$route_parameter => $item, 'pivot_id' => $qualification->pivot->id]) }}" id="delete-form-qualification{{ $qualification->pivot->id }}" method="POST" style="display: none;">
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
                            Инструменты
                        </h1>

                        <a href="{{ route($route_parameter.'.instruments.add', ['tech_operation' => $item->id]) }}" class="btn btn-primary lift">
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
                            <th scope="col">Инструмент</th>
                            <th scope="col">Кол-во</th>
                            <th scope="col">Характеристика</th>
                            <th scope="col"></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($item->instruments as $instrument)
                            <tr>
                                <th scope="row" style="width: 100px">{{ $loop->iteration }}</th>
                                <td>
                                    <div class="d-flex align-items-center">
                                        {{ $instrument->title }}
                                    </div>
                                </td>
                                <td>{{$instrument->pivot->count}}</td>
                                <td>{{$instrument->pivot->characteristics ?? '-'}}</td>
                                <td style="width: 200px">
                                    <div class="d-flex justify-content-end">
                                        <a href="{{ route($route_parameter.'.instruments.edit', [$route_parameter => $item, 'pivot_id' => $instrument->pivot->id]) }}" class="btn btn-sm btn-success"><i class="fe fe-edit-2"></i></a>
                                        <a class="btn btn-sm btn-danger ms-3" onclick="var result = confirm('Want to delete?');if (result){event.preventDefault();document.getElementById('delete-form-instrument{{ $instrument->pivot->id }}').submit();}"><i class="fe fe-trash"></i></a>
                                        <form action="{{ route($route_parameter.'.instruments.destroy', [$route_parameter => $item, 'pivot_id' => $instrument->pivot->id]) }}" id="delete-form-instrument{{ $instrument->pivot->id }}" method="POST" style="display: none;">
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
                            Техника
                        </h1>

                        <a href="{{ route($route_parameter.'.repair_equipments.add', ['tech_operation' => $item->id]) }}" class="btn btn-primary lift">
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
                            <th scope="col">Техника</th>
                            <th scope="col">Кол-во</th>
                            <th scope="col">Время работы</th>
                            <th scope="col">Характеристика</th>
                            <th scope="col"></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($item->repairEquipments as $repairEquipment)
                            <tr>
                                <th scope="row" style="width: 100px">{{ $loop->iteration }}</th>
                                <td>
                                    <div class="d-flex align-items-center">
                                        {{ $repairEquipment->title }}
                                    </div>
                                </td>
                                <td>{{$repairEquipment->pivot->count}}</td>
                                <td>{{$repairEquipment->pivot->hours.' ч '.$repairEquipment->pivot->minutes.' м'}}</td>
                                <td>{{$repairEquipment->pivot->characteristics ?? '-'}}</td>
                                <td style="width: 200px">
                                    <div class="d-flex justify-content-end">
                                        <a href="{{ route($route_parameter.'.repair_equipments.edit', [$route_parameter => $item, 'pivot_id' => $repairEquipment->pivot->id]) }}" class="btn btn-sm btn-success"><i class="fe fe-edit-2"></i></a>
                                        <a class="btn btn-sm btn-danger ms-3" onclick="var result = confirm('Want to delete?');if (result){event.preventDefault();document.getElementById('delete-form-repair_equipment{{ $repairEquipment->pivot->id }}').submit();}"><i class="fe fe-trash"></i></a>
                                        <form action="{{ route($route_parameter.'.repair_equipments.destroy', [$route_parameter => $item, 'pivot_id' => $repairEquipment->pivot->id]) }}" id="delete-form-repair_equipment{{ $repairEquipment->pivot->id }}" method="POST" style="display: none;">
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
