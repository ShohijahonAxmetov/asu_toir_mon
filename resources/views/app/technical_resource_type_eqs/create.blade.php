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
                                        <label for="type_equipment_id" class="form-label required">Тип оборудования</label>
                                        <select class="form-control mb-4 @error('type_equipment_id') is-invalid @enderror" name="type_equipment_id" required>
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
                                    <div class="form-group">
                                        <label for="technical_resource_id" class="form-label required">МТР</label>
                                        <select class="form-control mb-4 @error('technical_resource_id') is-invalid @enderror" name="technical_resource_id" required>
                                            @foreach ($technical_resources as $key => $item)
                                                <option value="{{ $item->id }}" {{ old('technical_resource_id') == $item->id ? 'selected' : '' }}>{{ $item->catalog_name }}</option>
                                            @endforeach
                                        </select>
                                        @error('technical_resource_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="parent_id" class="form-label">Родительский узел</label>
                                        <select class="form-control mb-4 @error('parent_id') is-invalid @enderror" name="parent_id">
                                            <option value=""></option>
                                            @foreach ($details as $key => $item)
                                                <option value="{{ $item->id }}" {{ old('arent_id', $parent_id) == $item->id ? 'selected' : '' }}>{{ $item->technicalResource->catalog_name }}</option>
                                            @endforeach
                                        </select>
                                        @error('parent_id')
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
