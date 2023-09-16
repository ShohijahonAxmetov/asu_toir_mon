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
@endsection
