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
                        <form method="post" action="{{ route($route_name . '.update', [$route_parameter => $plan_remont]) }}" enctype="multipart/form-data" id="add">
                            @csrf
                            @method('put')
                            <div class="row">
                                <div class="form-group">
                                    <label for="equipment_id" class="form-label required">Оборудования</label>
                                    <select class="form-control @error('equipment_id') is-invalid @enderror" name="equipment_id" required>
                                        @foreach ($equipments as $key => $item)
                                            <option value="{{ $item->id }}" {{ old('equipment_id', $plan_remont->equipment_id) == $item->id ? 'selected' : '' }}>{{ $item->garage_number }}</option>
                                        @endforeach
                                    </select>
                                    @error('equipment_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="remont_type_id" class="form-label required">Вид ремонта</label>
                                    <select class="form-control @error('remont_type_id') is-invalid @enderror" name="remont_type_id" required>
                                        @foreach ($remont_types as $key => $item)
                                            <option value="{{ $item->id }}" {{ old('remont_type_id', $plan_remont->remont_type_id) == $item->id ? 'selected' : '' }}>{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('remont_type_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="remont_begin" class="form-label required">Дата начала</label>
                                        <input type="date" required class="form-control @error('remont_begin') is-invalid @enderror" name="remont_begin" value="{{ old('remont_begin') ?? $plan_remont->remont_begin }}" id="remont_begin" placeholder="Дата начала...">
                                        @error('remont_begin')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="remont_end" class="form-label required">Дата окончания</label>
                                        <input type="date" required class="form-control @error('remont_end') is-invalid @enderror" name="remont_end" value="{{ old('remont_end') ?? $plan_remont->remont_end }}" id="remont_end" placeholder="Дата окончания...">
                                        @error('remont_end')
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
@endsection
