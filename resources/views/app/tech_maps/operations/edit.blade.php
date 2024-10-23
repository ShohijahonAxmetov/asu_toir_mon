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
            'name' => 'Добавление МТР',
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
                        <form method="post" action="{{ route($route_parameter . '.tech_resources.update', ['tech_operation' => $techOperation, 'pivot_id' => $pivot->id]) }}" id="add">
                            @csrf
                            @method('put')
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="technical_resource_id" class="form-label required">МТР</label>
                                        <select class="form-control mb-4 @error('technical_resource_id') is-invalid @enderror" name="technical_resource_id" required>
                                            @foreach ($technicalResources as $item)
                                                <option value="{{ $item->id }}" {{ old('technical_resource_id', $pivot->technical_resource_id) == $item->id ? 'selected' : '' }}>{{ $item->catalog_name }}</option>
                                            @endforeach
                                        </select>
                                        @error('unit_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-6">
                                                <label for="title" class="form-label required">Количество</label>
                                                <input type="text" class="form-control @error('quantity') is-invalid @enderror" name="quantity" value="{{ old('quantity', $pivot->quantity) }}" id="quantity" placeholder="Количество..." required>
                                                @error('quantity')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                            <div class="col-6">
                                                <label for="unit_id" class="form-label required">Ед. изм.</label>
                                                <select class="form-control mb-4 @error('unit_id') is-invalid @enderror" name="unit_id" required>
                                                    @foreach ($units as $item)
                                                        <option value="{{ $item->id }}" {{ old('unit_id', $pivot->unit_id) == $item->id ? 'selected' : '' }}>{{ $item->name }}</option>
                                                    @endforeach
                                                </select>
                                                @error('unit_id')
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
