@extends('layouts.app')

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
                    <div class="col-auto">

                        <!-- Button -->
                        <a href="{{ route($route_name.'.create') }}" class="btn btn-primary lift">
                            Добавить
                        </a>

                    </div>
                </div> <!-- / .row -->
            </div> <!-- / .header-body -->
            @include('app.components.breadcrumb', [
            'datas' => [
            [
            'active' => true,
            'url' => '',
            'name' => $title,
            'disabled' => false
            ]
            ]
            ])
        </div>
    </div> <!-- / .header -->

    <!-- filter -->
    <div class="container-fluid">
        <div class="card mt-4">
            <!-- <div class="card-header">
                <h3 class="mb-0">Фильтр</h3>
            </div> -->
            <div class="card-body">
                <form action="{{route($route_name.'.index')}}">
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="equipment_id" class="form-label">Оборудование</label>
                                <select class="form-control @error('equipment_id') is-invalid @enderror" name="equipment_id" data-choices>
                                    <option value="">Выберите из списка</option>
                                    @foreach ($equipments as $key => $item)
                                        <option value="{{ $item->id }}" {{ $item->id == $equipment_id ? 'selected' : '' }}>{{ $item->garage_number.' ('.$item->department->name.')' }}</option>
                                    @endforeach
                                </select>
                                @error('equipment_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="plan_remont_id" class="form-label">Ремонт</label>
                                <select class="form-control @error('plan_remont_id') is-invalid @enderror" name="plan_remont_id" data-choices>
                                    <option value="">Выберите из списка</option>
                                    @foreach ($plan_remonts as $key => $item)
                                        <option value="{{ $item->id }}" {{ $item->id == $plan_remont_id ? 'selected' : '' }}>{{ $item->remont_begin.' - '.$item->remont_end.' ('.$item->equipment->garage_number.')' }}</option>
                                    @endforeach
                                </select>
                                @error('plan_remont_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary lift">
                                Фильтр
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- CARDS -->
    <div class="container-fluid">
        <div class="card mt-4">
            <div class="card-body">
                <!-- Table -->
                <div class="table-responsive">
                    <table class="table table-sm table-hover mb-0">
                        <thead>
                        <tr>
                            <th scope="col" rowspan="2">#</th>
                            <th scope="col" rowspan="2">Тип оборудоваие и гар. №</th>
                            <th scope="col" rowspan="2">Дата ввода</th>
                            <th scope="col" rowspan="2">Состояние</th>
                            <th scope="col" rowspan="2">Номенклатурный №</th>
                            <th scope="col" rowspan="2">Необходимые запчасти</th>
                            <th scope="col" rowspan="2">Потребное количество</th>
                            <th scope="col" rowspan="2">На складе (дата)</th>
                            <th scope="col" rowspan="2">На складе (кол-во)</th>
                            <th scope="col" rowspan="2">Кол-во поставки</th>
                            <th scope="col" rowspan="2">Каталожный №</th>
                            <th scope="col" rowspan="2">Ед. изм.</th>
                            <th scope="col" rowspan="2">Срок поставки</th>
                            <th scope="col" rowspan="2">Дата заявки</th>
                            <th scope="col" rowspan="2">Договор (№)</th>
                            <th scope="col" rowspan="2">Договор (дата)</th>
                            <th scope="col" rowspan="2">Осталось время на поставку</th>
                            <th scope="col" rowspan="2">Дата начала ремонта по плану</th>
                            <th scope="col" rowspan="2">Осталось дней до начала ремонта</th>
                            <th scope="col" colspan="5" class="text-center">Ход исполнения</th>
                        </tr>
                        <tr>
                            <th scope="col">в производстве</th>
                            <th scope="col">изготовлено</th>
                            <th scope="col">в пути</th>
                            <th scope="col">на таможне</th>
                            <th scope="col">получено заказчиком</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($applications as $key => $item)
                            <tr>
                                <th scope="row" style="width: 100px">{{ $applications->firstItem() + $key }}</th>
                                <td>
                                    <div class="d-flex align-items-center">
                                        {{ $item->equipment->typeEquipment->name.' ('.$item->equipment->garage_number.')' }}
                                    </div>
                                </td>
                                <td>{{ $item->equipment->commissioning_date ?? '--' }}</td>
                                <td>{{ $item->equipment->eq_condition ?? '--' }}</td>
                                <td>{{ $item->technicalResource->nomen_number ?? '--' }}</td>
                                <td>{{ $item->technicalResource->catalog_name ?? '--' }}</td>
                                <td>{{ $item->required_quantity ?? '--' }}</td>
                                <td>{{ $item->warehouse_date ?? '--' }}</td>
                                <td>{{ $item->warehouse_quantity ?? '--' }}</td>
                                <td>{{ $item->declared_quantity ?? '--' }}</td>
                                <td>{{ $item->technicalResource->catalog_number ?? '--' }}</td>
                                <td>{{ $item->technicalResource->unit->name ?? '--' }}</td>
                                <td>{{ $item->delivery_date ? date('d-m-Y', strtotime($item->delivery_date)) : '--' }}</td>
                                <td>{{ isset($item->application_date) ? date('d-m-Y', strtotime($item->application_date)) : '--' }}</td>
                                @php
                                    if (isset($item->orderResource->order_date)) {
                                        if (isset($item->orderResource->contract_date)) {
                                            $flag_contact = false;
                                        } else {
                                            $add_days = $item->technicalResource->time_complete_order;
                                            $date1 = date('d-m-Y', strtotime($item->orderResource->order_date) + (24*3600*$add_days));
                                            $date2 = date('d-m-Y', strtotime($item->delivery_date));
                                            $dateTimestamp1 = strtotime($date1);
                                            $dateTimestamp2 = strtotime($date2);

                                            if ($dateTimestamp1 > $dateTimestamp2) {
                                                $flag_contact = true;
                                            } else {
                                                $flag_contact = false;
                                            }
                                        } 
                                    } else {
                                        $flag_contact = false;
                                    }  // 
                                @endphp
                                <td class="{{ $flag_contact ? 'bg-danger' : '' }}">{{ $item->orderResource->contract_number ?? '--' }}</td>
                                <td class="{{ $flag_contact ? 'bg-danger' : '' }}">{{ $item->orderResource->contract_date ?? '--' }}</td>
                                <td>{{ $item->delivery_date ? (strtotime($item->delivery_date) - strtotime(date('Y-m-d')))/86400 : '--' }}</td>
                                <td>{{ $item->remont_begin ? date('d-m-Y', strtotime($item->remont_begin)) : '--' }}</td>
                                <td>{{ $item->remont_begin ? (strtotime($item->remont_begin) - strtotime(date('Y-m-d')))/86400 : '--' }}</td>
                                <td class="{{ $item->orderResource ? ($item->orderResource->executionStatuse->id >= 3 ? 'bg-success' : '') : '' }}"></td>
                                <td class="{{ $item->orderResource ? ($item->orderResource->executionStatuse->id >= 4 ? 'bg-success' : '') : '' }}"></td>
                                <td class="{{ $item->orderResource ? ($item->orderResource->executionStatuse->id >= 4 ? 'bg-success' : '') : '' }}"></td>
                                <td class="{{ $item->orderResource ? ($item->orderResource->executionStatuse->id >= 5 ? 'bg-success' : '') : '' }}"></td>
                                <td class="{{ $item->orderResource ? ($item->orderResource->executionStatuse->id >= 7 ? 'bg-success' : '') : '' }}"></td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-4">
                    {{ $applications->links() }}
                </div>
            </div>
        </div>
    </div>

@endsection
