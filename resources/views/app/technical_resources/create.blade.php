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
                                        <label for="title" class="form-label required">Наименование каталожное</label>
                                        <input type="text" class="form-control @error('catalog_name') is-invalid @enderror" name="catalog_name" value="{{ old('catalog_name') }}" id="catalog_name" placeholder="Наименование каталожное..." required>
                                        @error('catalog_name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="title" class="form-label required">Каталожный №</label>
                                        <input type="text" class="form-control @error('catalog_number') is-invalid @enderror" name="catalog_number" value="{{ old('catalog_number') }}" id="catalog_number" placeholder="Каталожный №..." required>
                                        @error('catalog_number')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="title" class="form-label required">Наименование номенклатурное</label>
                                        <input type="text" class="form-control @error('nomen_name') is-invalid @enderror" name="nomen_name" value="{{ old('nomen_name') }}" id="nomen_name" placeholder="Наименование номенклатурное..." required>
                                        @error('nomen_name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="title" class="form-label required">Номенклатурный №</label>
                                        <input type="text" class="form-control @error('nomen_number') is-invalid @enderror" name="nomen_number" value="{{ old('nomen_number') }}" id="nomen_number" placeholder="Номенклатурный №..." required>
                                        @error('nomen_number')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="unit_id" class="form-label required">Ед. изм.</label>
                                        <select class="form-control mb-4 @error('unit_id') is-invalid @enderror" name="unit_id" required>
                                            <option value=""></option>
                                            @foreach ($units as $key => $item)
                                                <option value="{{ $item->id }}" {{ old('unit_id') == $item->id ? 'selected' : '' }}>{{ $item->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('unit_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="title" class="form-label required">Время, необходимое для выполнения заказа</label>
                                        <input type="text" class="form-control @error('time_complete_order') is-invalid @enderror" name="time_complete_order" value="{{ old('time_complete_order') }}" id="time_complete_order" placeholder="Время, необходимое для выполнения заказа..." required>
                                        @error('time_complete_order')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="title" class="form-label required">Время доставки</label>
                                        <input type="text" class="form-control @error('delivery_time') is-invalid @enderror" name="delivery_time" value="{{ old('delivery_time') }}" id="delivery_time" placeholder="Время доставки..." required>
                                        @error('delivery_time')
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
