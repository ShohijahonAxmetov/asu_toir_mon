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
                        <form method="post" action="{{ route($route_name . '.update', [$route_parameter => $tech_map]) }}" id="add">
                            @csrf
                            @method('put')
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="tech_map_group_id" class="form-label required">Группа</label>
                                        <select class="form-control mb-4 @error('tech_map_group_id') is-invalid @enderror" name="tech_map_group_id" required>
                                            <option value=""></option>
                                            @foreach ($tech_map_groups as $item)
                                                <option value="{{ $item->id }}" {{ old('tech_map_group_id', $tech_map->tech_map_group_id) == $item->id ? 'selected' : '' }}>{{ $item->title }}</option>
                                            @endforeach
                                        </select>
                                        @error('tech_map_group_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="title" class="form-label">Наименование</label>
                                        <input type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ old('title') ?? $tech_map->title ?? null }}" id="title" placeholder="Наименование...">
                                        @error('title')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="code" class="form-label">Код</label>
                                        <input type="text" class="form-control @error('code') is-invalid @enderror" name="code" value="{{ old('code', $tech_map->code) }}" id="code" placeholder="Код...">
                                        @error('code')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="title" class="form-label">Продолжительность</label>
                                        <div class="row">
                                            <div class="col-6">
                                                <label for="title" class="form-label required">Часы</label>
                                                <input type="text" class="form-control @error('hours') is-invalid @enderror" name="hours" value="{{ old('hours', $tech_map->hours) }}" id="hours" placeholder="Часы..." required>
                                                @error('hours')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                            <div class="col-6">
                                                <label for="title" class="form-label required">Минуты</label>
                                                <input type="text" class="form-control @error('minutes') is-invalid @enderror" name="minutes" value="{{ old('minutes', $tech_map->minutes) }}" id="minutes" placeholder="Минуты..." required>
                                                @error('minutes')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="comments" class="form-label">Комментарии</label>
                                        <textarea rows="5" class="form-control @error('comments') is-invalid @enderror" name="comments" id="comments" placeholder="Комментарии...">{{ old('comments', $tech_map->comments) }}</textarea>
                                        @error('comments')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    @if(is_null($tech_map->agreed_at))
                                    <div class="form-group">
                                        <label for="agreed" class="form-label required">Действующий документ</label>
                                        <select class="form-control mb-4 @error('agreed') is-invalid @enderror" name="agreed" required>
                                            <option value="no" {{$tech_map->agreed_at ? 'selected' : ''}}>Нет</option>
                                            <option value="yes" {{$tech_map->agreed_at ? 'selected' : ''}}>Да</option>
                                        </select>
                                        @error('agreed')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    @endif
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
