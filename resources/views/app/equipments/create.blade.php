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
                        <form method="post" action="{{ route($route_name . '.store') }}" enctype="multipart/form-data" id="add">
                            @csrf
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="department_id" class="form-label required">Подразделение</label>
                                        <select class="form-control mb-4 @error('department_id') is-invalid @enderror" name="department_id" required>
                                            @foreach ($departments as $key => $item)
                                                <option value="{{ $item->id }}" {{ old('department_id') == $item->id ? 'selected' : '' }}>{{ $item->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('department_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="type_equipment_id" class="form-label required">Тип оборудования</label>
                                        <select class="form-control mb-4 @error('type_equipment_id') is-invalid @enderror" name="type_equipment_id">
                                            @foreach ($type_equipments as $key => $item)
                                                <option value="{{ $item->id }}" {{ old('type_equipment_id') == $item->id ? 'selected' : '' }}>{{ $item->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('type_equipment_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    @foreach([['Гаражный номер', 'garage_number', 'text', 1],['Дата ввода', 'commissioning_date', 'date', 0],['Состояние','eq_condition','text', 0]] as $item)
                                    <div class="form-group">
                                        <label for="{{$item[1]}}" class="form-label @if($item[3]) required @endif">{{$item[0]}}</label>
                                        <input type="{{$item[2]}}" class="form-control @error($item[1]) is-invalid @enderror" name="{{$item[1]}}" value="{{ old($item[1]) }}" id="{{$item[1]}}" placeholder="{{$item[0]}}..." @if($item[3]) required @endif>
                                        @error($item[1])
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    @endforeach
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
