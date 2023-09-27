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
                                    <input type="hidden" name="application_id" value="{{$application_id}}">
                                    @if(isset($_GET['from_monitoring']))
                                    <input type="hidden" name="from_monitoring" value="1">
                                    @endif
                                    <!-- <div class="form-group">
                                        <label for="application_id" class="form-label required">Заявка</label>
                                        <select class="form-control @error('application_id') is-invalid @enderror" name="application_id" required>
                                            @foreach ($applications as $key => $item)
                                                <option value="{{ $item->id }}" {{ old('application_id') == $item->id ? 'selected' : '' }}>{{ $item->id }}</option>
                                            @endforeach
                                        </select>
                                        @error('application_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div> -->
                                    <div class="form-group">
                                        <label for="order_number" class="form-label required">№ заказа</label>
                                        <input type="text" class="form-control @error('order_number') is-invalid @enderror" name="order_number" value="{{ old('order_number') }}" id="order_number" placeholder="№ заказа..." required>
                                        @error('order_number')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="order_date" class="form-label required">Дата заказа</label>
                                        <input type="date" class="form-control @error('order_date') is-invalid @enderror" name="order_date" value="{{ old('order_date') }}" id="order_date" placeholder="Дата заказа..." required>
                                        @error('order_date')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="order_quantity" class="form-label required">Кол-во</label>
                                        <input type="text" class="form-control @error('order_quantity') is-invalid @enderror" name="order_quantity" value="{{ old('order_quantity') }}" id="order_quantity" placeholder="Кол-во..." required>
                                        @error('order_quantity')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="contract_number" class="form-label">Номер договора</label>
                                        <input type="text" class="form-control @error('contract_number') is-invalid @enderror" name="contract_number" value="{{ old('contract_number') }}" id="contract_number" placeholder="Номер договора...">
                                        @error('contract_number')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="contract_date" class="form-label">Дата договора</label>
                                        <input type="date" class="form-control @error('contract_date') is-invalid @enderror" name="contract_date" value="{{ old('contract_date') }}" id="contract_date" placeholder="Дата договора...">
                                        @error('contract_date')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="local_foreign" class="form-label">Договор (местный/зарубежный)</label>
                                        <select class="form-control mb-4 @error('local_foreign') is-invalid @enderror" name="local_foreign" id="local_foreign">
                                            <option value=""></option>
                                            <option value="1" {{ old('local_foreign') == 1 ? 'selected' : '' }}>местный</option>
                                            <option value="2" {{ old('local_foreign') == 2 ? 'selected' : '' }}>зарубежный</option>
                                        </select>
                                        @error('application_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="date_manufacture_contract" class="form-label">Дата изготовления (по договору)</label>
                                        <input type="date" class="form-control @error('date_manufacture_contract') is-invalid @enderror" name="date_manufacture_contract" value="{{ old('date_manufacture_contract') }}" id="date_manufacture_contract" placeholder="Дата изготовления (по договору)...">
                                        @error('date_manufacture_contract')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="payment_date" class="form-label">Дата оплаты договора</label>
                                        <input type="date" class="form-control @error('payment_date') is-invalid @enderror" name="payment_date" value="{{ old('payment_date') }}" id="payment_date" placeholder="Дата оплаты договора...">
                                        @error('payment_date')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="date_manufacture_fact" class="form-label">Дата изготовления (по факту)</label>
                                        <input type="date" class="form-control @error('date_manufacture_fact') is-invalid @enderror" name="date_manufacture_fact" value="{{ old('date_manufacture_fact') }}" id="date_manufacture_fact" placeholder="Дата изготовления (по факту)...">
                                        @error('date_manufacture_fact')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="exit_date" class="form-label">Покинул завод (дата)</label>
                                        <input type="date" class="form-control @error('exit_date') is-invalid @enderror" name="exit_date" value="{{ old('exit_date') }}" id="exit_date" placeholder="Покинул завод (дата)...">
                                        @error('exit_date')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="customs_date_receipt" class="form-label">Таможня (дата поступления)</label>
                                        <input type="date" class="form-control @error('customs_date_receipt') is-invalid @enderror" name="customs_date_receipt" value="{{ old('customs_date_receipt') }}" id="customs_date_receipt" placeholder="Таможня (дата поступления)...">
                                        @error('customs_date_receipt')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="customs_date_exit" class="form-label">Таможня (дата выхода)</label>
                                        <input type="date" class="form-control @error('customs_date_exit') is-invalid @enderror" name="customs_date_exit" value="{{ old('customs_date_exit') }}" id="customs_date_exit" placeholder="Таможня (дата выхода)...">
                                        @error('customs_date_exit')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="date_delivery_object" class="form-label">Дата доставки на объект</label>
                                        <input type="date" class="form-control @error('date_delivery_object') is-invalid @enderror" name="date_delivery_object" value="{{ old('date_delivery_object') }}" id="date_delivery_object" placeholder="Дата доставки на объект...">
                                        @error('date_delivery_object')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <input type="hidden" name="filter" value="{{$filter}}">
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
