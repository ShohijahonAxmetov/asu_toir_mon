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
                <form action="{{route('monitoring')}}">
                    <div class="row">
                        <div class="col-6" id="equipment_filter">
                            <div class="form-group">
                                <label for="equipment_id" class="form-label">Оборудование</label>
                                <select class="form-control @error('equipment_id') is-invalid @enderror" name="equipment_id" data-choices id="equipment_id">
                                    <option value="">Выберите из списка</option>
                                    @foreach ($equipments as $key => $item)
                                        <option value="{{ $item->id }}" verververv="oinbewion" {{ $item->id == $equipment_id ? 'selected' : '' }}>{{ $item->garage_number.' ('.$item->department->name.')' }}</option>
                                    @endforeach
                                </select>
                                @error('equipment_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-6" id="remont_filter">
                            <div class="form-group">
                                <label for="plan_remont_id" class="form-label">Ремонт</label>
                                <select class="form-control @error('plan_remont_id') is-invalid @enderror" name="plan_remont_id" data-choices id="remont_id">
                                    <option value="">Выберите из списка</option>
                                    @foreach ($plan_remonts as $key => $item)
                                        <option value="{{ $item->id }}" data-equipment_id="{{$item->equipment_id}}" {{ $item->id == $plan_remont_id ? 'selected' : '' }}>{{ $item->remont_begin.' - '.$item->remont_end.' ('.$item->equipment->garage_number.')' }}</option>
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
                            <th scope="col" rowspan="2">Тип оборудования и гар. №</th>
                            <th scope="col" rowspan="2">Дата ввода</th>
                            <th scope="col" rowspan="2">Состояние</th>
                            <th scope="col" rowspan="2">Номенклатурный №</th>
                            <th scope="col" rowspan="2">Наименования запчастей</th>
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
                            <th scope="col" rowspan="2">Договор (местный/зарубежный)</th>
                            <th scope="col" rowspan="2">Осталось время на поставку</th>
                            <th scope="col" rowspan="2">Дата начала ремонта по плану</th>
                            <th scope="col" rowspan="2">Осталось дней до начала ремонта</th>
                            <th scope="col" colspan="5" class="text-center">Ход исполнения на {{date('d-m-Y')}}</th>
                            <th scope="col" rowspan="2"></th> 
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
                                        {{ $item->equipment->typeEquipment->name.' № '.$item->equipment->garage_number.' ('.$item->equipment->department->name.')' }}
                                    </div>
                                </td>
                                <td>{{ isset($item->equipment->commissioning_date) ? date('d-m-Y', strtotime($item->equipment->commissioning_date)) : '--'}}</td>
                                <td>{{ $item->equipment->eq_condition ?? '--' }}</td>
                                <td>{{ $item->technicalResource->nomen_number ?? '--' }}</td>
                                <td>{{ $item->technicalResource->catalog_name ?? '--' }}</td>
                                <td>{{ $item->required_quantity ?? '--' }}</td>
                                <td>{{ isset($item->warehouse_date) ? date('d-m-Y', strtotime($item->warehouse_date)) : '--' }}</td>
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
                                    }
                                @endphp
                                <td class="{{ $flag_contact ? 'bg-danger' : '' }}">{{ $item->orderResource->contract_number ?? '--' }}</td>
                                <td class="{{ $flag_contact ? 'bg-danger' : '' }}">{{ isset($item->orderResource->contract_date) ? date('d-m-Y', strtotime($item->orderResource->contract_date)) : '--' }}</td>
                                <td class="{{ $flag_contact ? 'bg-danger' : '' }}">{{ isset($item->orderResource->local_foreign) ?( $item->orderResource->local_foreign != null ? ($item->orderResource->local_foreign == 1 ? 'местный' : 'зарубежный') : '--') : '--' }}</td>
                                <td class="{{(is_null($item->orderResource) || $item->orderResource->executionStatuse->id < 81) ? ((strtotime($item->delivery_date) - strtotime(date('Y-m-d')))/86400 < 0 ? 'bg-danger' : '') : ''}}">{{ ($item->orderResource && $item->orderResource->executionStatuse->id >= 81) ? '--' : ($item->delivery_date ? (strtotime($item->delivery_date) - strtotime(date('Y-m-d')))/86400 : '--') }}</td>
                                <td>{{ $item->remont_begin ? date('d-m-Y', strtotime($item->remont_begin)) : '--' }}</td>
                                <td class="{{(is_null($item->orderResource) || $item->orderResource->executionStatuse->id < 81) ? ((strtotime($item->remont_begin) - strtotime(date('Y-m-d')))/86400 < 0 ? 'bg-danger' : '') : ''}}">{{ ($item->orderResource && $item->orderResource->executionStatuse->id >= 81) ? '--' : ($item->remont_begin ? (strtotime($item->remont_begin) - strtotime(date('Y-m-d')))/86400 : '--') }}</td>
                                <td class="{{ $item->orderResource ? ($item->orderResource->executionStatuse->id == 31 ? 'bg-success' : '') : '' }} fw-bold h1">{{ $item->orderResource ? ($item->orderResource->executionStatuse->id == 31 ? '+' : '') : '' }}</td>
                                <td class="{{ $item->orderResource ? ($item->orderResource->executionStatuse->id == 41 ? 'bg-success' : '') : '' }} fw-bold h1">{{ $item->orderResource ? ($item->orderResource->executionStatuse->id == 41 ? '+' : '') : '' }}</td>
                                <td class="{{ $item->orderResource ? ($item->orderResource->executionStatuse->id == 51 || $item->orderResource->executionStatuse->id == 71 ? 'bg-success' : '') : '' }} fw-bold h1">{{ $item->orderResource ? ($item->orderResource->executionStatuse->id == 51 || $item->orderResource->executionStatuse->id == 71 ? '+' : '') : '' }}</td>
                                <td class="{{ $item->orderResource ? ($item->orderResource->executionStatuse->id == 61 ? 'bg-success' : '') : '' }} fw-bold h1">{{ $item->orderResource ? ($item->orderResource->executionStatuse->id == 61 ? '+' : '') : '' }}</td>
                                <td class="{{ $item->orderResource ? ($item->orderResource->executionStatuse->id == 81 ? 'bg-success' : '') : '' }} fw-bold h1">{{ $item->orderResource ? ($item->orderResource->executionStatuse->id == 81 ? '+' : '') : '' }}</td>
                                <td style="width: 200px">
                                    <div class="d-flex justify-content-end">
                                        @if(is_null($item->orderResource))
                                        <a href="{{ route($route_name.'.create', [$route_parameter => $item->id, 'application_id' => $item->id, 'from_monitoring' => 1]) }}" class="btn btn-sm btn-success me-3"><i class="fe fe-edit-2"></i></a>
                                        @else
                                        <a href="{{ route($route_name.'.edit', [$route_parameter => $item->orderResource, 'application_id' => $item->id, 'from_monitoring' => 1]) }}" class="btn btn-sm btn-success me-3"><i class="fe fe-edit-2"></i></a>
                                        @endif

                                        <a href="{{ route('monitoring.show', ['application_id' => $item->id]) }}" class="btn btn-sm btn-info"><i class="fe fe-eye"></i></a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-4">
                    {{ $applications->appends($_GET)->links() }}
                </div>
            </div>
        </div>
    </div>


    <!-- <select id="all_remonts">
        @foreach ($plan_remonts as $key => $item)
            <option value="{{ $item->id }}" data-equipment_id="{{$item->equipment_id}}" {{ $item->id == $plan_remont_id ? 'selected' : '' }}>{{ $item->remont_begin.' - '.$item->remont_end.' ('.$item->equipment->garage_number.')' }}</option>
        @endforeach
    </select> -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script type="text/javascript">
        let equipmentSelect = document.getElementById('equipment_id');
//         equipmentSelect.addEventListener('change', () => {
//             console.log(123);

//             let remontSelect = document.getElementById('remont_id');
//             let allRemonts = document.querySelectorAll('#all_remonts');

// console.log(allRemonts.innerHTML);

//             remontSelect.innerHTML = allRemonts.innerHTML;
//             let remontOptions = document.querySelectorAll('#remont_id>option');
//             console.log(remontOptions)

//             remontOptions.forEach((option) => {
//                 if (option.getAttribute('data-equipment_id') != equipmentSelect.value) {
//                     option.style.display = "none";
//                 } else {
//                     console.log(2);
//                 }
//             });
//         });
    </script>

@endsection
