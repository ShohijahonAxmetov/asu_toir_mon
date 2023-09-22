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
                        <form method="post" action="{{ route($route_name . '.update', [$route_parameter => $order_resource]) }}" enctype="multipart/form-data" id="add">
                            @csrf
                            @method('put')
                            <div class="row">
                                <input type="hidden" name="application_id" value="{{$application_id}}">
                                @if(isset($_GET['from_monitoring']))
                                <input type="hidden" name="from_monitoring" value="1">
                                @endif
                                <!-- <div class="form-group">
                                    <label for="application_id" class="form-label required">Заявка</label>
                                    <select class="form-control @error('application_id') is-invalid @enderror" name="application_id" required>
                                        @foreach ($applications as $key => $item)
                                            <option value="{{ $item->id }}" {{ old('application_id', $order_resource->application_id) == $item->id ? 'selected' : '' }}>{{ $item->id }}</option>
                                        @endforeach
                                    </select>
                                    @error('application_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div> -->
                                @foreach([['№ заказа', 'order_number', 'text', 1], ['Дата заказа', 'order_date', 'date', 1], ['Кол-во', 'order_quantity', 'text', 1], ['Номер договора', 'contract_number', 'text', 0], ['Дата договора', 'contract_date' ,'date', 0]] as $item)
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="{{$item[1]}}" class="form-label @if($item[3]) required @endif">{{$item[0]}}</label>
                                        <input type="{{$item[2]}}" @if($item[3]) required @endif class="form-control @error($item[1]) is-invalid @enderror" name="{{$item[1]}}" value="{{ old($item[1]) ?? $order_resource->{$item[1]} }}" id="{{$item[1]}}" placeholder="{{$item[0]}}...">
                                        @error($item[1])
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                @endforeach
                                <div class="form-group">
                                    <label for="local_foreign" class="form-label">Договор (местный/зарубежный)</label>
                                    <select class="form-control @error('local_foreign') is-invalid @enderror" name="local_foreign" id="local_foreign">
                                        <option value=""></option>
                                        <option value="1" {{ old('local_foreign', $order_resource->local_foreign) == 1 ? 'selected' : '' }}>местный</option>
                                        <option value="2" {{ old('local_foreign', $order_resource->local_foreign) == 2 ? 'selected' : '' }}>зарубежный</option>
                                    </select>
                                    @error('application_id')
                                    <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                @foreach([['Дата изготовления (по договору)', 'date_manufacture_contract', 'date', 0], ['Дата изготовления (по факту)', 'date_manufacture_fact', 'date', 0], ['Покинул завод (дата)', 'exit_date', 'date', 0], ['Таможня (дата поступления)', 'customs_date_receipt', 'date', 0], ['Таможня (дата выхода)', 'customs_date_exit', 'date', 0], ['Дата доставки на объект', 'date_delivery_object' ,'date', 0]] as $item)
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="{{$item[1]}}" class="form-label @if($item[3]) required @endif">{{$item[0]}}</label>
                                            <input type="{{$item[2]}}" @if($item[3]) required @endif class="form-control @error($item[1]) is-invalid @enderror" name="{{$item[1]}}" value="{{ old($item[1]) ?? $order_resource->{$item[1]} }}" id="{{$item[1]}}" placeholder="{{$item[0]}}...">
                                            @error($item[1])
                                            <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                            @enderror
                                        </div>
                                    </div>
                                @endforeach
                                <input type="hidden" name="filter" value="{{$filter}}">
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
