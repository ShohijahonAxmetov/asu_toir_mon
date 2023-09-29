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
                            <a href="{{ route($route_name . '.graph', [$route_parameter => $equipment]) }}" class="btn btn-secondary lift">Структура</a>
							<a href="{{ route($route_name . '.edit', [$route_parameter => $equipment]) }}" class="btn btn-primary lift ms-3">Редактировать</a>
							<a class="btn btn-danger lift ms-3" onclick="var result = confirm('Вы уверены?');if (result){event.preventDefault();document.getElementById('delete-form{{ $equipment->id }}').submit();}"> Удалить</a>
							<form action="{{ route($route_name . '.destroy', [$route_parameter => $equipment]) }}" id="delete-form{{ $equipment->id }}" method="POST" style="display: none;">
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
                            <th scope="row">Гаражный номер</th>
                            <td class="">{{$equipment->garage_number}}</td>
                        </tr>
                        <tr>
                            <th scope="row">Тип оборудования</th>
                            <td class="">{{$equipment->typeEquipment->name}}</td>
                        </tr>
                        <tr>
                            <th scope="row">Подразделение</th>
                            <td class="">{{$equipment->department->name ?? '--'}}</td>
                        </tr>
                        <tr>
                            <th scope="row">Дата ввода</th>
                            <td class="">{{$equipment->commissioning_date ?? '--'}}</td>
                        </tr>
                        <tr>
                            <th scope="row">Состояние</th>
                            <td class="">{{$equipment->eq_condition ?? '--'}}</td>
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
                            Запланированные ремонты
                        </h1>

{{--                        <a href="{{route('requirements_year_applications.create', ['application' => $year_application, 'mtr' => $year_application->technical_resource_id])}}" class="btn btn-primary">Добавить</a>--}}

                    </div>
                </div> <!-- / .row -->
            </div> <!-- / .header-body -->
        </div>
    </div> <!-- / .header -->

    <!-- CARDS -->
    <div class="container-fluid">
        <div class="card mt-4">
            <div class="card-body">
                <!-- Table -->
                <div class="table-responsive">
                    <table class="table table-sm table-hover mb-0">
                        <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Вид ремонта</th>
                            <th scope="col">Дата начала</th>
                            <th scope="col">Дата окончания</th>
                            <th scope="col"></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($equipment->planRemonts as $key => $item)
                            <tr>
                                <th scope="row" style="width: 100px">{{ $loop->iteration }}</th>
                                <td>
                                    <div class="d-flex align-items-center">
                                        {{ $item->remontType->name ?? '--' }}
                                    </div>
                                </td>
                                <td>{{ $item->remont_begin ?? '--' }}</td>
                                <td>{{ $item->remont_end ?? '--' }}</td>
{{--                                <td style="width: 200px">--}}
{{--                                    <div class="d-flex justify-content-end">--}}
{{--                                        <a href="{{ route('requirements_year_applications.edit', ['requirements_year_application' => $item, 'application' => $year_application, 'mtr' => $year_application->technical_resource_id]) }}" class="btn btn-sm btn-info"><i class="fe fe-edit-2"></i></a>--}}
{{--                                        <a class="btn btn-sm btn-danger ms-3" onclick="var result = confirm('Want to delete?');if (result){event.preventDefault();document.getElementById('delete-form{{ $item->id }}').submit();}"><i class="fe fe-trash"></i></a>--}}
{{--                                        <form action="{{ route('requirements_year_applications.destroy', ['requirements_year_application' => $item]) }}" id="delete-form{{ $item->id }}" method="POST" style="display: none;">--}}
{{--                                            @csrf--}}
{{--                                            @method('DELETE')--}}
{{--                                        </form>--}}
{{--                                    </div>--}}
{{--                                </td>--}}
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection
