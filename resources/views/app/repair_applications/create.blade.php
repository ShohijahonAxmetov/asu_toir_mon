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
                                        <label for="application_date" class="form-label required">Дата заявки</label>
                                        <input type="date" class="form-control @error('application_date') is-invalid @enderror" name="application_date" value="{{ old('application_date') }}" id="application_date" placeholder="Дата начала...">
                                        @error('application_date')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="equipment_id" class="form-label required">Оборудование</label>
                                        <select class="form-control mb-4 @error('equipment_id') is-invalid @enderror" name="equipment_id" required>
                                            @foreach ($equipments as $key => $item)
                                                <option value="{{ $item->id }}" {{ old('equipment_id') == $item->id ? 'selected' : '' }}>{{ $item->typeEquipment->name . '  № ' . $item->garage_number . '  ( ' . $item->department->name . '  ) ' }}</option>
                                            @endforeach
                                        </select>
                                        @error('equipment_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="plan_remont_id" class="form-label required">Ремонт</label>
                                        <select class="form-control mb-4 @error('plan_remont_id') is-invalid @enderror" name="plan_remont_id" required>
                                            @foreach ($plan_remonts as $key => $item)
                                                <option value="{{ $item->id }}" {{ old('plan_remont_id') == $item->id ? 'selected' : '' }}>{{ date('d-m-Y', strtotime($item->remont_begin)) . ' - ' . date('d-m-Y', strtotime($item->remont_end)) . '  ( ' . $item->equipment->typeEquipment->name . '  № ' . $item->equipment->garage_number . '  ) '}}</option>
                                            @endforeach
                                        </select>
                                        @error('plan_remont_id')
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
