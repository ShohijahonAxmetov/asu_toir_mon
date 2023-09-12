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
        <form method="post" action="{{ route($route_name . '.store') }}" enctype="multipart/form-data" id="add">
            <div class="row">
                <div class="col-8">
                    <div class="card mw-50">
                        <div class="card-body">
                            <form method="post" action="{{ route($route_name . '.store') }}" enctype="multipart/form-data" id="add">
                                @csrf
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="name" class="form-label required">Название</label>
                                            <input type="text" required class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" id="name" placeholder="Заголовок...">
                                            @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="planned" class="form-label required">Плановая дата</label>
                                            <input type="date" required class="form-control @error('planned') is-invalid @enderror" name="planned" value="{{ old('planned') }}" id="planned" placeholder="Заголовок...">
                                            @error('planned')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="type_technical_inspection_id" class="form-label">Тип технического обслужования</label>
                                            <select class="form-control mb-4 @error('categories') is-invalid @enderror" name="type_technical_inspection_id">
                                                @foreach ($type_technical_inspections as $key => $item)
                                                    <option value="{{ $item->id }}" {{ (old('type_technical_inspection_id') ? in_array($item->id, old('type_technical_inspection_id')) : '') ? 'selected' : '' }}>{{ $item->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('type_technical_inspection_id')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="">
                                                    <label for="desc" class="form-label">Описание</label>
                                                </div>
                                                <div class="c">
                                                    <textarea id="desc" cols="4" rows="4" class="form-control @error('desc') is-invalid @enderror" name="desc">{{ old('desc') ?? $product->desc ?? null }}</textarea>
                                                    @error('desc')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Button -->
                                <div class="model-btns d-flex justify-content-end">
                                    <a href="{{ route($route_name.'.index') }}" type="button" class="btn btn-secondary">Отмена</a>
                                    <button type="submit" class="btn btn-primary ms-2">Сохранить</button>
                                </div>
                        </div>
                    </div>
                </div>
                <div class="col-4">
                    <div class="card mw-50">
                        <div class="card-body">
                            @csrf
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="equipment_id" class="form-label">Оборудование</label>
                                        <select class="form-control mb-4 @error('categories') is-invalid @enderror" name="equipment_id">
                                            @foreach ($equipments as $key => $item)
                                                <option value="{{ $item->id }}" {{ (old('equipment_id') ? in_array($item->id, old('equipment_id')) : '') ? 'selected' : '' }}>{{ $item->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('equipment_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
