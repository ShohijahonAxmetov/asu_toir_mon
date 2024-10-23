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
            'name' => 'Добавление квалификации',
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
                        <form method="post" action="{{ route($route_parameter . '.qualifications.update', ['tech_operation' => $techOperation, 'pivot_id' => $pivot->id]) }}" id="add">
                            @csrf
                            @method('put')
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="qualification_id" class="form-label required">Квалификация</label>
                                        <select class="form-control mb-4 @error('qualification_id') is-invalid @enderror" name="qualification_id" required>
                                            @foreach ($qualifications as $item)
                                                <option value="{{ $item->id }}" {{ old('qualification_id', $pivot->qualification_id) == $item->id ? 'selected' : '' }}>{{ $item->title }}</option>
                                            @endforeach
                                        </select>
                                        @error('qualification_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="title" class="form-label required">Количество</label>
                                        <input type="text" class="form-control @error('count') is-invalid @enderror" name="count" value="{{ old('count', $pivot->count) }}" id="count" placeholder="Количество..." required>
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
                                                <input type="text" class="form-control @error('hours') is-invalid @enderror" name="hours" value="{{ old('hours', $pivot->hours) }}" id="hours" placeholder="Часы..." required>
                                                @error('hours')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                            <div class="col-6">
                                                <label for="title" class="form-label required">Минуты</label>
                                                <input type="text" class="form-control @error('minutes') is-invalid @enderror" name="minutes" value="{{ old('minutes', $pivot->minutes) }}" id="minutes" placeholder="Минуты..." required>
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
                                        <textarea rows="5" class="form-control @error('characteristics') is-invalid @enderror" name="characteristics" id="characteristics" placeholder="Характеристика...">{{ old('characteristics', $pivot->characteristics) }}</textarea>
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
                                <!-- <input type="submit" name="action" value="Сохранить" class="btn btn-success ms-2" /> -->
                                <!-- <input type="submit" name="action" value="Сохранить и добавить еще" class="btn btn-primary ms-2" /> -->
                                <button type="submit" class="btn btn-success ms-2" >Сохранить</button>
                                <!-- <button type="submit" class="btn btn-primary ms-2">Сохранить и добавить еще</button> -->
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
