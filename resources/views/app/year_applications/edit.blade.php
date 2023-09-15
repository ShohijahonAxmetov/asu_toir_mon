@extends('layouts.app')

@section('links')

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
                </div> <!-- / .row -->
            </div> <!-- / .header-body -->
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
            'name' => 'Добавление',
            'disabled' => true
            ],
            ]
            ])
        </div>
    </div> <!-- / .header -->

    <!-- CARDS -->
    <div class="container-fluid">
        <div class="row">
            <div class="col-8">
                <div class="card mw-50">
                    <div class="card-body">
                        <form method="post" action="{{ route($route_name . '.update', [$route_parameter => $year_application]) }}" enctype="multipart/form-data" id="add">
                            @csrf
                            @method('put')
                            <div class="row">
                                <div class="form-group">
                                    <label for="department_id" class="form-label required">Рудоуправление</label>
                                    <select class="form-control @error('department_id') is-invalid @enderror" name="department_id" required>
                                        @foreach ($departments as $key => $item)
                                            <option value="{{ $item->id }}" {{ old('department_id', $year_application->department_id) == $item->id ? 'selected' : '' }}>{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('department_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="technical_resource_id" class="form-label required">МТР</label>
                                    <select class="form-control @error('technical_resource_id') is-invalid @enderror" name="technical_resource_id" required>
                                        @foreach ($technical_resources as $key => $item)
                                            <option value="{{ $item->id }}" {{ old('technical_resource_id', $year_application->technical_resource_id) == $item->id ? 'selected' : '' }}>{{ $item->catalog_name }}</option>
                                        @endforeach
                                    </select>
                                    @error('technical_resource_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="year" class="form-label required">Год</label>
                                        <input type="text" required class="form-control @error('year') is-invalid @enderror" name="year" value="{{ old('year') ?? $year_application->year }}" id="year" placeholder="Год...">
                                        @error('year')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <!-- Button -->
                            <div class="model-btns d-flex justify-content-end">
                                <a href="{{ route($route_name.'.index') }}" type="button" class="btn btn-secondary">Отмена</a>
                                <button type="submit" class="btn btn-primary ms-2">Сохранить</button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
            <div class="col-4">

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
                                        <a class="btn btn-sm btn-danger ms-3" onclick="var result = confirm('Want to delete?');if (result){event.preventDefault();document.getElementById('delete-form{{ $item->id }}').submit();}"><i class="fe fe-trash"></i></a>
                                        <form action="{{ route('requirements_year_applications.destroy', ['requirements_year_application' => $item]) }}" id="delete-form{{ $item->id }}" method="POST" style="display: none;">
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
