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
                        <form method="post" action="{{ route($route_name . '.update', [$route_parameter => $technical_resource]) }}" enctype="multipart/form-data" id="add">
                            @csrf
                            @method('put')
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="catalog_name" class="form-label">Наименование каталожное</label>
                                        <input type="text" class="form-control @error('catalog_name') is-invalid @enderror" name="catalog_name" value="{{ old('catalog_name') ?? $technical_resource->catalog_name ?? null }}" id="catalog_name" placeholder="Наименование каталожное...">
                                        @error('catalog_name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="catalog_number" class="form-label">Каталожный №</label>
                                        <input type="text" class="form-control @error('catalog_number') is-invalid @enderror" name="catalog_number" value="{{ old('catalog_number') ?? $technical_resource->catalog_number ?? null }}" id="catalog_number" placeholder="Каталожный №...">
                                        @error('catalog_number')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="nomen_name" class="form-label">Наименование номенклатурное</label>
                                        <input type="text" class="form-control @error('nomen_name') is-invalid @enderror" name="nomen_name" value="{{ old('nomen_name') ?? $technical_resource->nomen_name ?? null }}" id="nomen_name" placeholder="Наименование номенклатурное...">
                                        @error('nomen_name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="nomen_number" class="form-label">Номенклатурный №</label>
                                        <input type="text" class="form-control @error('nomen_number') is-invalid @enderror" name="nomen_number" value="{{ old('nomen_number') ?? $technical_resource->nomen_number ?? null }}" id="nomen_number" placeholder="Номенклатурный №...">
                                        @error('nomen_number')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="time_complete_order" class="form-label">Время, необходимое для выполнения заказа</label>
                                        <input type="text" class="form-control @error('time_complete_order') is-invalid @enderror" name="time_complete_order" value="{{ old('time_complete_order') ?? $technical_resource->time_complete_order ?? null }}" id="time_complete_order" placeholder="Время, необходимое для выполнения заказа...">
                                        @error('time_complete_order')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="delivery_time" class="form-label">Время доставки</label>
                                        <input type="text" class="form-control @error('delivery_time') is-invalid @enderror" name="delivery_time" value="{{ old('delivery_time') ?? $technical_resource->delivery_time ?? null }}" id="delivery_time" placeholder="Время доставки...">
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
