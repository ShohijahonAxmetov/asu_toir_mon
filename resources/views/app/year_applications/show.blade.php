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

							<a href="{{ route($route_name . '.edit', [$route_parameter => $year_application]) }}" class="btn btn-primary lift">Редактировать</a>
							<a class="btn btn-danger lift ms-3" onclick="var result = confirm('Вы уверены?');if (result){event.preventDefault();document.getElementById('delete-form{{ $year_application->id }}').submit();}"> Удалить</a>
							<form action="{{ route($route_name . '.destroy', [$route_parameter => $year_application]) }}" id="delete-form{{ $year_application->id }}" method="POST" style="display: none;">
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
                            <th scope="row">Рудоуправление</th>
                            <td class="">{{$year_application->department->name}}</td>
                        </tr>
                        <tr>
                            <th scope="row">Год</th>
                            <td class="">{{$year_application->year}}</td>
                        </tr>
                        <tr>
                            <th scope="row">МТР</th>
                            <td class="">{{$year_application->technicalResource->catalog_name ?? '--'}}</td>
                        </tr>
                        <tr>
                            <th scope="row">Ед. изм.</th>
                            <td class="">{{$year_application->technicalResource->unit->name ?? '--'}}</td>
                        </tr>
                        <tr>
                            <th scope="row">Кол-во на год</th>
                            <td class="">{{ $year_application->quantity}}</td>
                        </tr>
                        @foreach($month as $key => $item)
                            @php $monthKey = 'quantity_m'.($key+1); @endphp
                            <tr>
                                <th scope="row">Количество по месяцам ({{$item}})</th>
                                <td class="">{{ $year_application->$monthKey}}</td>
                            </tr>
                        @endforeach
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
                            Потребность в узлах, деталях и материалах к годовому графику ППР
                        </h1>

                        <a href="{{route('requirements_year_applications.create', ['application' => $year_application, 'mtr' => $year_application->technical_resource_id])}}" class="btn btn-primary">Добавить</a>

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
                            <th scope="col">Оборудование</th>
                            <th scope="col">Месяц</th>
                            <th scope="col">Ремонт</th>
                            <th scope="col">Потребное количество на ремонт</th>
                            <th scope="col">Склад</th>
                            <th scope="col">Склад (дата)</th>
                            <th scope="col">Склад (кол-во)</th>
                            <th scope="col">Заявлено (кол-во)</th>
                            <th scope="col">Дата поставки</th>
                            <th scope="col">Дата добавления</th>
                            <th scope="col"></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($year_application->requirements as $key => $item)
                            <tr>
                                <th scope="row" style="width: 100px">{{ $loop->iteration }}</th>
                                <td>
                                    <div class="d-flex align-items-center">
                                        {{ $item->equipment->garage_number ?? '--' }}
                                    </div>
                                </td>
                                <td>{{ $item->month ?? '--' }}</td>
                                <td>{{ $item->planRemont->remont_begin ?? '--' }}</td>
                                <td>{{ $item->required_quantity ?? '--' }}</td>
                                <td>{{ $item->warehouse_number ?? '--' }}</td>
                                <td>{{ $item->warehouse_date ?? '--' }}</td>
                                <td>{{ $item->warehouse_quantity ?? '--' }}</td>
                                <td>{{ $item->declared_quantity ?? '--' }}</td>
                                <td>{{ isset($item->delivery_date) ? date('d-m-Y', strtotime($item->delivery_date)) : '--' }}</td>
                                <td>{{ isset($item->created_at) ? date('d-m-Y', strtotime($item->created_at)) : '--' }}</td>
                                <td style="width: 200px">
                                    <div class="d-flex justify-content-end">
                                        <a href="{{ route('requirements_year_applications.edit', ['requirements_year_application' => $item, 'application' => $year_application, 'mtr' => $year_application->technical_resource_id]) }}" class="btn btn-sm btn-info"><i class="fe fe-edit-2"></i></a>
                                        <a class="btn btn-sm btn-danger ms-3" onclick="var result = confirm('Want to delete?');if (result){event.preventDefault();document.getElementById('delete2-form{{ $item->id }}').submit();}"><i class="fe fe-trash"></i></a>
                                        <form action="{{ route('requirements_year_applications.destroy', ['requirements_year_application' => $item]) }}" id="delete2-form{{ $item->id }}" method="POST" style="display: none;">
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
