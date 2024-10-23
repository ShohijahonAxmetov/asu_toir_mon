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
            'url' => route($route_name.'.show', ['tech_map' => $tech_map]),
            'name' => $tech_map->title,
            'disabled' => false
            ],
            [
            'active' => true,
            'url' => '',
            'name' => 'Добавление техопераций',
            'disabled' => true
            ],
            ]
            ])
        </div>
    </div> <!-- / .header -->

    <!-- CARDS -->
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card mw-50">
                    <div class="card-body">
                        <form method="post" action="{{ route($route_parameter . '.operations.store', ['tech_map' => $tech_map]) }}" id="add">
                            @csrf
                            <!-- Button -->
                            <div class="model-btns d-flex justify-content-end mb-4">
                                <a href="{{ route($route_name.'.show', ['tech_map' => $tech_map]) }}" type="button" class="btn btn-secondary">Отмена</a>
                                <button class="btn btn-success ms-2">Сохранить</button>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group mb-2">
                                        <div class="row">
                                            <div class="col-1">
                                                <label for="title" class="form-label">Порядок</label>
                                            </div>
                                            <div class="col-6">
                                                <label for="unit_id" class="form-label">Выберите Технолоническую операцию</label>
                                            </div>
                                            <div class="col-5">
                                                <label for="unit_id" class="form-label">Выберите Технолоническую карту</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @for($i=1; $i<101; $i++)
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group mb-2">
                                        <div class="row">
                                            <div class="col-1">
                                                <input type="text" class="form-control @error('position.'.$i) is-invalid @enderror" name="position[{{$i}}]" value="{{ old('position.'.$i, $tech_map_operations->where('position', $i)->first()->position ?? $i) }}" id="position" placeholder="Порядок..." required>
                                                @error('position.'.$i)
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                            <div class="col-5">
                                                <select class="form-control mb-2 @error('tech_operation_id.'.$i) is-invalid @enderror" name="tech_operation_id[{{$i}}]">
                                                    <option value=""></option>
                                                    @foreach ($tech_operations as $techOperation)
                                                        <option value="{{ $techOperation->id }}" {{ old('tech_operation_id.'.$i, ($tech_map_operations->where('position', $i)->where('model', 'App\Models\TechMaps\TechOperation')->first() ? $tech_map_operations->where('position', $i)->where('model', 'App\Models\TechMaps\TechOperation')->first()->model_id : '')) == $techOperation->id ? 'selected' : '' }}>{{ $techOperation->title }}</option>
                                                    @endforeach
                                                </select>
                                                @error('tech_operation_id.'.$i)
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                            <div class="col-1 d-flex justify-content-center align-items-center">
                                                ИЛИ
                                            </div>
                                            <div class="col-5">
                                                <select class="form-control mb-2 @error('tech_map_id.'.$i) is-invalid @enderror" name="tech_map_id[{{$i}}]">
                                                    <option value=""></option>
                                                    @foreach ($tech_maps as $techMap)
                                                        <option value="{{ $techMap->id }}" {{ old('tech_map_id.'.$i, $tech_map_operations->where('position', $i)->where('model', 'App\Models\TechMaps\TechMap')->first() ? $tech_map_operations->where('position', $i)->where('model', 'App\Models\TechMaps\TechMap')->first()->model_id : '') == $techMap->id ? 'selected' : '' }}>{{ $techMap->title }}</option>
                                                    @endforeach
                                                </select>
                                                @error('tech_map_id')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endfor
                            <!-- Button -->
                            <div class="model-btns d-flex justify-content-end">
                                <a href="{{ route($route_name.'.show', ['tech_map' => $tech_map]) }}" type="button" class="btn btn-secondary">Отмена</a>
                                <button class="btn btn-success ms-2">Сохранить</button>
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
