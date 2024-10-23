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
                        <form method="post" action="{{ route($route_name . '.update', [$route_parameter => $repair]) }}" id="add">
                            @csrf
                            @method('put')
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="tech_map_id" class="form-label required">Техническая карта</label>
                                        <select class="form-control @error('tech_map_id') is-invalid @enderror" name="tech_map_id" required>
                                            @foreach ($tech_maps as $key => $item)
                                                <option value="{{ $item->id }}" {{ old('tech_map_id', $repair->tech_map_id) == $item->id ? 'selected' : '' }}>{{ $item->title }}</option>
                                            @endforeach
                                        </select>
                                        @error('tech_map_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="started_at" class="form-label">Время начало ремонта</label>
                                        <input type="text" class="form-control @error('started_at') is-invalid @enderror" name="started_at" value="{{ old('started_at') ?? $repair->started_at ?? null }}" id="started_at" placeholder="Время начало ремонта..." data-flatpickr='{"enableTime": "true", "dateFormat": "Y-m-d H:i"}'>
                                        @error('started_at')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="ended_at" class="form-label">Время конца ремонта</label>
                                        <input type="text" class="form-control @error('ended_at') is-invalid @enderror" name="ended_at" value="{{ old('ended_at') ?? $repair->ended_at ?? null }}" id="ended_at" placeholder="Время конца ремонта..." data-flatpickr='{"enableTime": "true", "dateFormat": "Y-m-d H:i"}'>
                                        @error('ended_at')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="comments" class="form-label">Комментарии</label>
                                        <textarea rows="5" class="form-control @error('comments') is-invalid @enderror" name="comments" id="comments" placeholder="Комментарии...">{{ old('comments', $repair->comments) }}</textarea>
                                        @error('comments')
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
