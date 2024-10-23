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
                        <form method="post" action="{{ route($route_name . '.store') }}" id="add">
                            @csrf
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="tech_operation_stage_id" class="form-label required">Этап</label>
                                        <select class="form-control mb-4 @error('tech_operation_stage_id') is-invalid @enderror" name="tech_operation_stage_id" required>
                                            <option value=""></option>
                                            @foreach ($techOperationStages as $item)
                                                <option value="{{ $item->id }}" {{ old('tech_operation_stage_id') == $item->id ? 'selected' : '' }}>{{ $item->title }}</option>
                                            @endforeach
                                        </select>
                                        @error('tech_operation_stage_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="title" class="form-label required">Наименование</label>
                                        <input type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ old('title') }}" id="title" placeholder="Наименование..." required>
                                        @error('title')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="full_title" class="form-label">Наименование полное</label>
                                        <input type="text" class="form-control @error('full_title') is-invalid @enderror" name="full_title" value="{{ old('full_title') }}" id="full_title" placeholder="Наименование полное...">
                                        @error('full_title')
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
                                                <input type="text" class="form-control @error('hours') is-invalid @enderror" name="hours" value="{{ old('hours', 0) }}" id="hours" placeholder="Часы..." required>
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
                                        <label for="title" class="form-label">Расценка</label>
                                        <input type="text" class="form-control @error('amount') is-invalid @enderror" name="amount" value="{{ old('amount') }}" id="amount" placeholder="Расценка...">
                                        @error('amount')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="content" class="form-label">Содержание работ</label>
                                        <textarea rows="5" class="form-control @error('content') is-invalid @enderror" name="content" id="content" placeholder="Содержание работ...">{{ old('content') }}</textarea>
                                        @error('content')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="comments" class="form-label">Комментарии</label>
                                        <textarea rows="5" class="form-control @error('comments') is-invalid @enderror" name="comments" id="comments" placeholder="Комментарии...">{{ old('comments') }}</textarea>
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
