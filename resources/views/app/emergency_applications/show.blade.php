@extends('layouts.app', ['el_id' => 'show_page'])

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
                        
							<a href="{{ route($route_name . '.edit', [$route_parameter => $emergency_application]) }}" class="btn btn-primary lift">Редактировать</a>
							<a class="btn btn-danger lift ms-3" onclick="var result = confirm('Вы уверены?');if (result){event.preventDefault();document.getElementById('delete-form{{ $emergency_application->id }}').submit();}"> Удалить</a>
							<form action="{{ route($route_name . '.destroy', [$route_parameter => $emergency_application]) }}" id="delete-form{{ $emergency_application->id }}" method="POST" style="display: none;">
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
                    'disabled' => false
                ]
            ]
        ])
        <div class="card mw-50">
            <div class="card-body">
                <table class="table table-bordered table-striped">
                    <tbody>
                        <tr>
                            <th scope="row">Дата заявки</th>
                            <td class="">{{ isset($emergency_application->application_date) ? date('d-m-Y', strtotime($emergency_application->application_date)) : '--' }}</td>
                        </tr>
                        <tr>
                            <th scope="row">Оборудование</th>
                            <td class="">{{ $emergency_application->equipment->typeEquipment->name . '  № ' . $emergency_application->equipment->garage_number . '  ( ' . $emergency_application->equipment->department->name . '  ) ' }}</td>
                        </tr>
                        <tr>
                            <th scope="row">Ремонт</th>
                            <td class="">{{ date('d-m-Y', strtotime($emergency_application->planRemont->remont_begin)) . ' - ' . date('d-m-Y', strtotime($emergency_application->planRemont->remont_end)) . '  ( ' . $emergency_application->planRemont->remontType->name . '  ) ' }}</td>
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
                            Потребность в узлах, деталях и материалах для ремонта
                        </h1>

                        <a href="{{route($route_name_sub.'.create', ['id_application' => $emergency_application, 'id_equipment' => $emergency_application->equipment_id])}}" class="btn btn-primary">Добавить</a>

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
                            <th scope="col">Узел, деталь</th>
                            <th scope="col">Потребное количество на ремонт</th>
                            <th scope="col">Номер склада</th>
                            <th scope="col">Склад (дата)</th>
                            <th scope="col">Склад (кол-во)</th>
                            <th scope="col">Заявлено (кол-во)</th>
                            <th scope="col">Дата поставки</th>
                            <th scope="col">Дата добавления</th>
                            <th scope="col"></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($sub_table as $key => $item)
                            <tr>
                                <th scope="row" style="width: 100px">{{ $loop->iteration }}</th>
                                <td>
                                    <div class="d-flex align-items-center">
                                        {{ $item->technicalResource->catalog_name ?? '--' }}
                                    </div>
                                </td>
                                <td>{{ $item->required_quantity ?? '--' }}</td>
                                <td>{{ $item->warehouse_number ?? '--' }}</td>
                                <td>{{ isset($item->warehouse_date) ? date('d-m-Y', strtotime($item->warehouse_date)) : '--' }} </td>
                                <td>{{ $item->warehouse_quantity ?? '--' }}</td>
                                <td>{{ $item->declared_quantity ?? '--' }}</td>
                                <td>{{ isset($item->delivery_date) ? date('d-m-Y', strtotime($item->delivery_date)) : '--' }}</td>
                                <td>{{ isset($item->created_at) ? date('d-m-Y', strtotime($item->created_at)) : '--' }}</td>
                                <td style="width: 200px">
                                    <div class="d-flex justify-content-end">
                                        <a href="{{ route('req_emergency_applications.edit', ['req_emergency_application' => $item, 'application' => $item]) }}" class="btn btn-sm btn-info"><i class="fe fe-edit-2"></i></a>
                                        <a class="btn btn-sm btn-danger ms-3" onclick="var result = confirm('Want to delete?');if (result){event.preventDefault();document.getElementById('delete-form{{ $item->id }}').submit();}"><i class="fe fe-trash"></i></a>
                                        <form action="{{ route('req_emergency_applications.destroy', ['req_emergency_application' => $item]) }}" id="delete-form{{ $item->id }}" method="POST" style="display: none;">
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