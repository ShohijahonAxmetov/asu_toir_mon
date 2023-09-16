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
                        <form method="post" action="{{ route($route_name . '.update', [$route_parameter => $requirement_year_application]) }}" enctype="multipart/form-data" id="add">
                            @csrf
                            @method('put')
                            <div class="row">
                                <div class="form-group">
                                    <label for="equipment_id" class="form-label required">Оборудование</label>
                                    <select class="form-control @error('equipment_id') is-invalid @enderror" name="equipment_id" required>
                                        @foreach ($equipments as $key => $item)
                                            <option value="{{ $item->id }}" {{ old('equipment_id', $requirement_year_application->equipment_id) == $item->id ? 'selected' : '' }}>{{ $item->garage_number }}</option>
                                        @endforeach
                                    </select>
                                    @error('equipment_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="month" class="form-label required">Месяц</label>
                                    <select class="form-control @error('month') is-invalid @enderror" name="month" required>
                                        @foreach ($month as $key => $item)
                                            <option value="{{ $key }}" {{ old('month', $requirement_year_application->month) == $key ? 'selected' : '' }}>{{ $item }}</option>
                                        @endforeach
                                    </select>
                                    @error('month')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="plan_remont_id" class="form-label required">Ремонт</label>
                                    <select class="form-control @error('plan_remont_id') is-invalid @enderror" name="plan_remont_id" required>
                                        @foreach ($plan_remonts as $key => $item)
                                            <option value="{{ $item->id }}" {{ old('plan_remont_id', $requirement_year_application->plan_remont_id) == $item->id ? 'selected' : '' }}>{{ $item->remont_begin.' - '.$item->remont_end }}</option>
                                        @endforeach
                                    </select>
                                    @error('plan_remont_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="required_quantity" class="form-label required">Потребное количество на ремонт</label>
                                        <input type="text" required class="form-control @error('required_quantity') is-invalid @enderror" name="required_quantity" value="{{ old('required_quantity') ?? $requirement_year_application->required_quantity }}" id="required_quantity" placeholder="Потребное количество на ремонт...">
                                        @error('required_quantity')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="warehouse_number" class="form-label required">Склад</label>
                                        <input type="text" required class="form-control @error('warehouse_number') is-invalid @enderror" name="warehouse_number" value="{{ old('warehouse_number') ?? $requirement_year_application->warehouse_number }}" id="warehouse_number" placeholder="Склад...">
                                        @error('warehouse_number')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="warehouse_date" class="form-label required">Склад (дата)</label>
                                        <input type="date" required class="form-control @error('warehouse_date') is-invalid @enderror" name="warehouse_date" value="{{ old('warehouse_date') ?? $requirement_year_application->warehouse_date }}" id="warehouse_date" placeholder="Склад (дата)...">
                                        @error('warehouse_date')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="warehouse_quantity" class="form-label required">Склад (кол-во)</label>
                                        <input type="text" required class="form-control @error('warehouse_quantity') is-invalid @enderror" name="warehouse_quantity" value="{{ old('warehouse_quantity') ?? $requirement_year_application->warehouse_quantity }}" id="warehouse_quantity" placeholder="Склад (кол-во)...">
                                        @error('warehouse_quantity')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="declared_quantity" class="form-label required">Заявлено (кол-во)</label>
                                        <input type="text" required class="form-control @error('declared_quantity') is-invalid @enderror" name="declared_quantity" value="{{ old('declared_quantity') ?? $requirement_year_application->declared_quantity }}" id="declared_quantity" placeholder="Заявлено (кол-во)...">
                                        @error('declared_quantity')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="delivery_date" class="form-label required">Дата поставки</label>
                                        <input type="date" required class="form-control @error('delivery_date') is-invalid @enderror" name="delivery_date" value="{{ old('delivery_date') ?? $requirement_year_application->delivery_date }}" id="delivery_date" placeholder="Дата поставки...">
                                        @error('delivery_date')
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
                            <input type="hidden" name="year_application_id" value="{{$application}}">
                            <input type="hidden" name="technical_resource_id" value="{{$mtr}}">
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-4">

            </div>
        </div>
    </div>
@endsection
