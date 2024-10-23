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
            'name' => 'Добавление инструмента',
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
                        <form method="post" action="{{ route($route_parameter . '.instruments.update', ['tech_operation' => $techOperation, 'pivot_id' => $pivot->id]) }}" id="add">
                            @csrf
                            @method('put')
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="instrument_id" class="form-label required">Инструмент</label>
                                        <select class="form-control mb-4 @error('instrument_id') is-invalid @enderror" name="instrument_id" required>
                                            @foreach ($instruments as $item)
                                                <option value="{{ $item->id }}" {{ old('instrument_id', $pivot->instrument_id) == $item->id ? 'selected' : '' }}>{{ $item->title }}</option>
                                            @endforeach
                                        </select>
                                        @error('instrument_id')
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
