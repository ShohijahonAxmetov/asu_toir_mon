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
            'name' => 'Добавление Мер безопасности',
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
                        <form method="post" action="{{ route($route_parameter.'.security_measures.store', ['tech_map' => $tech_map]) }}" id="add">
                            @csrf
                            <div class="row">
                                <div class="col-12">
                                    @if($security_measures->first())
                                    <div class="form-group">
                                        <label for="security_measure_id" class="form-label">Выбрать из существующих</label>
                                        <select class="form-control mb-4 @error('security_measure_id') is-invalid @enderror" name="security_measure_id">
                                            <option value=""></option>
                                            @foreach ($security_measures as $item)
                                                <option value="{{ $item->id }}" {{ old('security_measure_id') == $item->id ? 'selected' : '' }}>{{ $item->title }}</option>
                                            @endforeach
                                        </select>
                                        @error('security_measure_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    @endif
                                    <p class="h2 mb-3">Создать новую</p>
                                    <div class="form-group">
                                        <label for="title" class="form-label">Заголовок</label>
                                        <input type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ old('title') }}" id="title" placeholder="Заголовок...">
                                        @error('title')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="desc" class="form-label">Описание</label>
                                        <textarea rows="8" class="form-control @error('desc') is-invalid @enderror" name="desc" id="desc" placeholder="Описание...">{{ old('desc') }}</textarea>
                                        @error('desc')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>                                    
                                </div>
                            </div>
                            <!-- Button -->
                            <div class="model-btns d-flex justify-content-end">
                                <a href="{{ route($route_name.'.show', ['tech_map' => $tech_map]) }}" type="button" class="btn btn-secondary">Отмена</a>
                                <input type="submit" name="action" value="Сохранить" class="btn btn-success ms-2" />
                                <input type="submit" name="action" value="Сохранить и добавить еще" class="btn btn-primary ms-2" />
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
