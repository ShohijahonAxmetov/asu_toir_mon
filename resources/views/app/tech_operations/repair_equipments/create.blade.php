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
            'active' => false,
            'url' => route($route_name.'.show', ['tech_operation' => $techOperation]),
            'name' => $techOperation->title,
            'disabled' => false
            ],
            [
            'active' => true,
            'url' => '',
            'name' => 'Добавление Техники',
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
                        <form method="post" action="{{ route($route_parameter.'.repair_equipments.store', ['tech_operation' => $techOperation]) }}" id="add">
                            @csrf
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="repair_equipment_id" class="form-label required">Техника</label>
                                        <select class="form-control mb-4 @error('repair_equipment_id') is-invalid @enderror" name="repair_equipment_id" required>
                                            @foreach ($repairEquipments as $item)
                                                <option value="{{ $item->id }}" {{ old('repair_equipment_id') == $item->id ? 'selected' : '' }}>{{ $item->title }}</option>
                                            @endforeach
                                        </select>
                                        @error('repair_equipment_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="title" class="form-label required">Количество</label>
                                        <input type="text" class="form-control @error('count') is-invalid @enderror" name="count" value="{{ old('count', 1) }}" id="count" placeholder="Количество..." required>
                                        @error('count')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="title" class="form-label required">Время работы</label>
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
                                                <label for="title" class="form-label required">Минуты</label>
                                                <input type="text" class="form-control @error('minutes') is-invalid @enderror" name="minutes" value="{{ old('minutes', 0) }}" id="minutes" placeholder="Минуты..." required>
                                                @error('minutes')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="characteristics" class="form-label">Характеристика</label>
                                        <textarea rows="5" class="form-control @error('characteristics') is-invalid @enderror" name="characteristics" id="characteristics" placeholder="Характеристика...">{{ old('characteristics') }}</textarea>
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
                                <a href="{{ route($route_name.'.show', ['tech_operation' => $techOperation]) }}" type="button" class="btn btn-secondary">Отмена</a>
                                <input type="submit" name="action" value="Сохранить" class="btn btn-success ms-2" />
                                <input type="submit" name="action" value="Сохранить и добавить еще" class="btn btn-primary ms-2" />
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
