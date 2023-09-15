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
                        
							<a href="{{ route($route_name . '.edit', [$route_parameter => $repair_application]) }}" class="btn btn-primary lift">Update</a>
							<a class="btn btn-danger lift ms-3" onclick="var result = confirm('Вы уверены?');if (result){event.preventDefault();document.getElementById('delete-form{{ $repair_application->id }}').submit();}"> Delete</a>
							<form action="{{ route($route_name . '.destroy', [$route_parameter => $repair_application]) }}" id="delete-form{{ $repair_application->id }}" method="POST" style="display: none;">
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
            'active' => true,
            'url' => '',
            'name' => $title,
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
                            <td class="">{{ isset($repair_application->application_date) ? date('d-m-Y', strtotime($repair_application->application_date)) : '--' }}</td>
                        </tr>
                        <tr>
                            <th scope="row">Оборудование</th>
                            <td class="">{{ $repair_application->equipment->typeEquipment->name . '  № ' . $repair_application->equipment->garage_number . '  ( ' . $repair_application->equipment->department->name . '  ) ' }}</td>
                        </tr>
                        <tr>
                            <th scope="row">Ремонт</th>
                            <td class="">{{ date('d-m-Y', strtotime($repair_application->planRemont->remont_begin)) . ' - ' . date('d-m-Y', strtotime($repair_application->planRemont->remont_end)) . '  ( ' . $repair_application->planRemont->remontType->name . '  ) ' }}</td>
                        </tr>

                    </tbody>
                </table>
            </div>
        </div>
        
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
                        
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        
    </div>
    
@endsection